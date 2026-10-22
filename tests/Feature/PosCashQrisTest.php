<?php

namespace Tests\Feature;

use App\Enums\PaymentMethod;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PosCheckoutService;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PosCashQrisTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Product $productA;
    protected Product $productB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@yansfood.id',
            'role' => 'admin',
        ]);

        $category = ProductCategory::create([
            'name' => 'Makanan Utama',
            'slug' => 'makanan-utama',
        ]);

        $this->productA = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Ayam Goreng',
            'slug' => 'nasi-ayam-goreng',
            'price' => 20000,
            'stock' => 50,
            'is_available' => true,
        ]);

        $this->productB = Product::create([
            'category_id' => $category->id,
            'name' => 'Es Teh Manis',
            'slug' => 'es-teh-manis',
            'price' => 5000,
            'stock' => 100,
            'is_available' => true,
        ]);
    }

    public function test_cash_payment_exact_amount_succeeds(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.pos.pay-cash'), [
            'cash_tendered' => 25000,
            'items' => [
                ['product_id' => $this->productA->id, 'quantity' => 1],
                ['product_id' => $this->productB->id, 'quantity' => 1],
            ],
            'customer_name' => 'Budi Santoso',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('transactions', [
            'customer_name' => 'Budi Santoso',
            'payment_method' => PaymentMethod::CASH->value,
            'total' => 25000,
            'amount_paid' => 25000,
            'change' => 0,
            'status' => 'completed',
        ]);

        $tx = Transaction::latest('id')->first();
        $this->assertNotNull($tx->paid_at);
        $response->assertRedirect(route('admin.transactions.receipt', $tx));
    }

    public function test_cash_payment_with_change_succeeds(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.pos.pay-cash'), [
            'cash_tendered' => 50000,
            'items' => [
                ['product_id' => $this->productA->id, 'quantity' => 2], // 40,000
            ],
            'customer_name' => 'Siti',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('transactions', [
            'customer_name' => 'Siti',
            'payment_method' => PaymentMethod::CASH->value,
            'total' => 40000,
            'amount_paid' => 50000,
            'change' => 10000,
            'status' => 'completed',
        ]);
    }

    public function test_cash_payment_insufficient_tender_fails_validation(): void
    {
        $this->actingAs($this->admin);

        $response = $this->from(route('admin.pos.index'))->post(route('admin.pos.pay-cash'), [
            'cash_tendered' => 15000,
            'items' => [
                ['product_id' => $this->productA->id, 'quantity' => 1], // 20,000
            ],
        ]);

        $response->assertSessionHasErrors(['cash_tendered']);
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_qris_prepare_creates_token_and_redirects(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.pos.qris.prepare'), [
            'items' => [
                ['product_id' => $this->productA->id, 'quantity' => 1],
                ['product_id' => $this->productB->id, 'quantity' => 2],
            ],
            'customer_name' => 'Dewi',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('transactions', 0); // No transaction yet before confirm

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringContainsString('/admin/pos/qris?token=', $targetUrl);

        parse_str(parse_url($targetUrl, PHP_URL_QUERY), $queryParams);
        $token = $queryParams['token'] ?? null;
        if (!$token && preg_match('#/admin/pos/qris/([^/?]+)#', $targetUrl, $matches)) {
            $token = $matches[1];
        }
        $this->assertNotNull($token);

        $cached = Cache::get("pos:qris:{$token}");
        $this->assertNotNull($cached);
        $this->assertEquals(30000, $cached['total']);
        $this->assertEquals('Dewi', $cached['customer_name']);
    }

    public function test_qris_confirm_creates_transaction_and_clears_cache(): void
    {
        $this->actingAs($this->admin);

        $service = app(PosCheckoutService::class);
        $payload = $service->prepareQris([
            ['product_id' => $this->productA->id, 'quantity' => 1],
        ], $this->admin->id, 0.0, 'Dewi QRIS');
        $token = $payload['token'];

        $response = $this->post(route('admin.pos.qris.confirm', $token));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'customer_name' => 'Dewi QRIS',
            'payment_method' => PaymentMethod::QRIS->value,
            'total' => 20000,
            'amount_paid' => 20000,
            'change' => 0,
            'status' => 'completed',
        ]);

        $tx = Transaction::latest('id')->first();
        $this->assertNotNull($tx->paid_at);
        $response->assertRedirect(route('admin.transactions.receipt', $tx));
        $this->assertNull(Cache::get("pos:qris:{$token}"));
    }

    public function test_qris_confirm_is_idempotent(): void
    {
        $this->actingAs($this->admin);

        $service = app(PosCheckoutService::class);
        $payload = $service->prepareQris([
            ['product_id' => $this->productA->id, 'quantity' => 1],
        ], $this->admin->id, 0.0, 'Idempotent User');
        $token = $payload['token'];

        // First click
        $resp1 = $this->post(route('admin.pos.qris.confirm', $token));
        $tx1 = Transaction::latest('id')->first();
        $resp1->assertRedirect(route('admin.transactions.receipt', $tx1));

        // Second click (replay)
        $resp2 = $this->post(route('admin.pos.qris.confirm', $token));
        $resp2->assertRedirect(route('admin.transactions.receipt', $tx1));

        // Still only 1 transaction created
        $this->assertEquals(1, Transaction::where('customer_name', 'Idempotent User')->count());
    }

    public function test_qris_cancel_removes_token_and_flashes_cart_restore(): void
    {
        $this->actingAs($this->admin);

        $service = app(PosCheckoutService::class);
        $payload = $service->prepareQris([
            ['product_id' => $this->productA->id, 'quantity' => 1],
        ], $this->admin->id, 0.0, 'Batal User');
        $token = $payload['token'];

        $response = $this->post(route('admin.pos.qris.cancel', $token));
        $response->assertRedirect(route('admin.pos.index'));
        $response->assertSessionHas('restore_cart');
        $this->assertNull(Cache::get("pos:qris:{$token}"));
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_qris_expired_or_invalid_token_redirects_with_error(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.pos.qris.show', ['token' => 'nonexistent_token_123']));
        $response->assertRedirect(route('admin.pos.index'));
        $response->assertSessionHas('error');
    }

    public function test_qris_token_belonging_to_another_user_is_forbidden(): void
    {
        $otherAdmin = User::factory()->create([
            'email' => 'other@yansfood.id',
            'role' => 'admin',
        ]);

        $service = app(PosCheckoutService::class);
        $payload = $service->prepareQris([
            ['product_id' => $this->productA->id, 'quantity' => 1],
        ], $otherAdmin->id);
        $token = $payload['token'];

        // Access as $this->admin instead of $otherAdmin
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.pos.qris.show', ['token' => $token]));
        $response->assertStatus(403);
    }

    public function test_financial_report_has_three_matching_records_and_no_catering(): void
    {
        $this->actingAs($this->admin);

        // Create completed Cash transactions
        Transaction::create([
            'transaction_number' => 'TRX-CASH-1',
            'user_id' => $this->admin->id,
            'customer_name' => 'Cash Customer',
            'payment_method' => PaymentMethod::CASH,
            'subtotal' => 60000,
            'tax' => 0,
            'discount' => 0,
            'total' => 60000,
            'amount_paid' => 60000,
            'change' => 0,
            'status' => 'completed',
            'paid_at' => now(),
            'transaction_date' => now()->toDateString(),
            'transaction_time' => now()->toTimeString(),
        ]);

        // Create completed QRIS transactions
        Transaction::create([
            'transaction_number' => 'TRX-QRIS-1',
            'user_id' => $this->admin->id,
            'customer_name' => 'QRIS Customer',
            'payment_method' => PaymentMethod::QRIS,
            'subtotal' => 40000,
            'tax' => 0,
            'discount' => 0,
            'total' => 40000,
            'amount_paid' => 40000,
            'change' => 0,
            'status' => 'completed',
            'paid_at' => now(),
            'transaction_date' => now()->toDateString(),
            'transaction_time' => now()->toTimeString(),
        ]);

        // Create approved expense
        $expCat = ExpenseCategory::create(['name' => 'Bahan Baku', 'slug' => 'bahan-baku']);
        Expense::create([
            'user_id' => $this->admin->id,
            'expense_category_id' => $expCat->id,
            'amount' => 30000,
            'description' => 'Beli Ayam',
            'status' => 'approved',
            'expense_date' => now()->toDateString(),
        ]);

        $reportService = app(ReportService::class);
        $financial = $reportService->getFinancialReport(now()->toDateString(), now()->toDateString());

        $summary = $financial['payment_summary'];
        $this->assertEquals(60000, $summary['cash_total']);
        $this->assertEquals(1, $summary['cash_count']);
        $this->assertEquals(60.0, $summary['cash_percent']);

        $this->assertEquals(40000, $summary['qris_total']);
        $this->assertEquals(1, $summary['qris_count']);
        $this->assertEquals(40.0, $summary['qris_percent']);

        $this->assertEquals(100000, $summary['combined_total']);
        $this->assertEquals(2, $summary['combined_count']);

        // Check Net Profit: 100,000 (POS Cash + QRIS) - 30,000 (Expense) = 70,000
        $this->assertEquals(100000, $financial['total_gross_income']);
        $this->assertEquals(30000, $financial['total_expenses']);
        $this->assertEquals(70000, $financial['net_profit']);
        $this->assertEquals(70.0, $financial['profit_margin']);

        // Verify report index blade renders
        $resp = $this->get(route('admin.reports.index', ['tab' => 'financial', 'period' => 'today']));
        $resp->assertOk();
        $resp->assertSee('Catatan 1: Cash (Tunai)');
        $resp->assertSee('Catatan 2: QRIS');
        $resp->assertSee('Catatan 3: Total Gabungan');
        $resp->assertSee('Rp 100.000');
    }

    public function test_csv_export_includes_utf8_bom_and_three_records(): void
    {
        $this->actingAs($this->admin);

        Transaction::create([
            'transaction_number' => 'TRX-TEST-CSV',
            'user_id' => $this->admin->id,
            'customer_name' => 'CSV Customer',
            'payment_method' => PaymentMethod::CASH,
            'subtotal' => 50000,
            'tax' => 0,
            'discount' => 0,
            'total' => 50000,
            'amount_paid' => 50000,
            'change' => 0,
            'status' => 'completed',
            'paid_at' => now(),
            'transaction_date' => now()->toDateString(),
            'transaction_time' => now()->toTimeString(),
        ]);

        $response = $this->get(route('admin.reports.export', ['tab' => 'financial', 'period' => 'today']));
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringStartsWith("\xEF\xBB\xBF", $content);
        $this->assertStringContainsString('RINGKASAN METODE PEMBAYARAN KASIR POS', $content);
        $this->assertStringContainsString('Catatan 1: Pembayaran CASH (Tunai)', $content);
        $this->assertStringContainsString('Catatan 2: Pembayaran QRIS (Non-Tunai)', $content);
        $this->assertStringContainsString('Catatan 3: Total Gabungan (Cash + QRIS)', $content);
    }

    public function test_qris_static_image_upload_in_settings(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->image('qris_sample.png', 400, 400);

        $response = $this->post(route('admin.settings.update'), [
            'merchant_name' => "Yan's Food Official",
            'qris_image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $qrisPath = Setting::get('qris_image_path');
        $this->assertNotNull($qrisPath);
        Storage::disk('public')->assertExists($qrisPath);
        $this->assertEquals("Yan's Food Official", Setting::get('merchant_name'));
    }
}
