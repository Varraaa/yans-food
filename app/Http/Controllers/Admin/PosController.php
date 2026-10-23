<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PayCashRequest;
use App\Http\Requests\Admin\PrepareQrisRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Services\PosCheckoutService;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::where('name', 'not like', '%katering%')
            ->where('name', 'not like', '%ketring%')
            ->withCount('products')
            ->get();
        $products = Product::where('status', 'available')
            ->with('category')
            ->orderBy('name')
            ->get();

        $qrisImage = Setting::get('qris_image_path');
        if (empty($qrisImage)) {
            $settingsFile = storage_path('app/settings.json');
            if (file_exists($settingsFile)) {
                $saved = json_decode(file_get_contents($settingsFile), true) ?? [];
                $qrisImage = $saved['qris_image_path'] ?? null;
            }
        }
        if (empty($qrisImage) || (!file_exists(public_path($qrisImage)) && !file_exists(storage_path('app/public/' . $qrisImage)))) {
            if (file_exists(public_path('images/qris/qris-yansfood.jpeg'))) {
                $qrisImage = 'images/qris/qris-yansfood.jpeg';
            }
        }
        $qrisConfigured = !empty($qrisImage);

        return view('admin.pos.index', compact('categories', 'products', 'qrisConfigured'));
    }

    /**
     * Memproses pembayaran Cash
     */
    public function payCash(PayCashRequest $request, PosCheckoutService $posService, ReceiptService $receiptService)
    {
        try {
            $transaction = $posService->payCash(
                items: $request->validated('items'),
                amountPaid: (float) $request->validated('amount_paid'),
                cashierId: Auth::id() ?? 1,
                discount: (float) ($request->validated('discount') ?? 0),
                customerName: $request->validated('customer_name')
            );

            $receipt = $receiptService->generateCustomerReceipt($transaction);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Cash berhasil disimpan!',
                    'transaction' => $transaction,
                    'receipt' => $receipt,
                    'redirect_url' => route('admin.transactions.receipt', $transaction->id),
                ]);
            }

            return redirect()->route('admin.transactions.receipt', $transaction->id)
                ->with('success', 'Transaksi Cash berhasil disimpan!');
        } catch (\Throwable $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mempersiapkan sesi pembayaran QRIS (Server side calculation)
     */
    public function prepareQris(PrepareQrisRequest $request, PosCheckoutService $posService)
    {
        try {
            $result = $posService->prepareQris(
                items: $request->validated('items'),
                cashierId: Auth::id() ?? 1,
                discount: (float) ($request->validated('discount') ?? 0),
                customerName: $request->validated('customer_name')
            );

            $showUrl = route('admin.pos.qris.show', $result['token']);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'token' => $result['token'],
                    'redirect_url' => $showUrl,
                ]);
            }

            return redirect($showUrl);
        } catch (\Throwable $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Halaman QR Code QRIS untuk ditunjukkan ke pelanggan
     */
    public function showQris(string $token, PosCheckoutService $posService)
    {
        $session = $posService->getQrisSession($token);

        if (!$session) {
            return redirect()->route('admin.pos.index')
                ->with('error', 'Sesi pembayaran QRIS sudah kedaluwarsa atau tidak valid, silakan ulangi.');
        }

        // Jika sudah pernah dibuat, langsung arahkan ke struk
        if (!empty($session['transaction_id'])) {
            return redirect()->route('admin.transactions.receipt', $session['transaction_id']);
        }

        $qrisImagePath = Setting::get('qris_image_path');
        $qrisMerchantName = Setting::get('qris_merchant_name', "YAN'S FOOD NASI GORENG, R");

        if (empty($qrisImagePath)) {
            $settingsFile = storage_path('app/settings.json');
            if (file_exists($settingsFile)) {
                $saved = json_decode(file_get_contents($settingsFile), true) ?? [];
                $qrisImagePath = $saved['qris_image_path'] ?? null;
                $qrisMerchantName = $saved['qris_merchant_name'] ?? $qrisMerchantName;
            }
        }

        if (empty($qrisImagePath) || (!file_exists(public_path($qrisImagePath)) && !file_exists(storage_path('app/public/' . $qrisImagePath)))) {
            if (file_exists(public_path('images/qris/qris-yansfood.jpeg'))) {
                $qrisImagePath = 'images/qris/qris-yansfood.jpeg';
            }
        }

        return view('admin.pos.qris', [
            'token' => $token,
            'session' => $session,
            'qrisImagePath' => $qrisImagePath,
            'qrisMerchantName' => $qrisMerchantName,
            'total' => (float) $session['total'],
        ]);
    }

    /**
     * Konfirmasi pembayaran QRIS (Tombol Next)
     */
    public function confirmQris(string $token, Request $request, PosCheckoutService $posService)
    {
        try {
            $transaction = $posService->confirmQris($token, Auth::id() ?? 1);

            return redirect()->route('admin.transactions.receipt', $transaction->id)
                ->with('success', 'Pembayaran QRIS berhasil dikonfirmasi!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.pos.index')
                ->with('error', 'Gagal memproses QRIS: ' . $e->getMessage());
        }
    }

    /**
     * Membatalkan sesi QRIS dan kembali ke POS dengan keranjang utuh
     */
    public function cancelQris(string $token, PosCheckoutService $posService)
    {
        $items = $posService->cancelQris($token);

        return redirect()->route('admin.pos.index')
            ->with('restore_cart', $items)
            ->with('info', 'Pembayaran QRIS dibatalkan. Keranjang belanja telah dipulihkan.');
    }

    /**
     * Endpoint checkout kasir (kompatibel mundur)
     */
    public function checkout(Request $request, TransactionService $transactionService, ReceiptService $receiptService)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'in:CASH,QRIS'],
            'customer_name' => ['required', 'string', 'max:100'],
        ]);

        try {
            $transaction = $transactionService->createTransaction(
                items: $validated['items'],
                amountPaid: (float) $validated['amount_paid'],
                cashierId: Auth::id() ?? 1,
                discount: (float) ($validated['discount'] ?? 0),
                paymentMethod: $validated['payment_method'],
                customerName: $validated['customer_name']
            );

            $receipt = $receiptService->generateCustomerReceipt($transaction);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi kasir berhasil disimpan!',
                'transaction' => $transaction,
                'receipt' => $receipt,
                'redirect_url' => route('admin.transactions.receipt', $transaction->id),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
