<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class PosPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'TRANSACTION';

    protected static ?string $navigationLabel = 'POS (Kasir)';

    protected static ?string $title = 'Sistem Kasir POS';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.pos-page';

    public ?string $searchQuery = '';
    public ?int $selectedCategoryId = null;

    // Cart state: [productId => ['id' => x, 'name' => y, 'price' => z, 'quantity' => q, 'unit' => u]]
    public array $cart = [];

    public float $discount = 0;
    public float $amountPaid = 0;

    // Transaction state after success
    public ?int $completedTransactionId = null;
    public ?array $completedReceipt = null;

    public function mount(): void
    {
        $this->cart = [];
        $this->amountPaid = 0;
        $this->discount = 0;
    }

    public function addToCart(int $productId): void
    {
        $product = Product::query()
            ->where('id', $productId)
            ->where('status', 'available')
            ->first();

        if (! $product) {
            Notification::make()
                ->title('Produk tidak tersedia')
                ->danger()
                ->send();
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += 1;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'unit' => $product->unit,
                'quantity' => 1,
            ];
        }

        $this->updateAmountPaidIfAuto();
    }

    public function updateQuantity(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            unset($this->cart[$productId]);
        } elseif (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = $quantity;
        }

        $this->updateAmountPaidIfAuto();
    }

    public function removeFromCart(int $productId): void
    {
        unset($this->cart[$productId]);
        $this->updateAmountPaidIfAuto();
    }

    public function clearCart(): void
    {
        $this->cart = [];
        $this->amountPaid = 0;
        $this->discount = 0;
    }

    public function setExactPayment(): void
    {
        $this->amountPaid = $this->calculateTotal();
    }

    public function setNominal(float $nominal): void
    {
        $this->amountPaid = $nominal;
    }

    protected function updateAmountPaidIfAuto(): void
    {
        if ($this->amountPaid > 0 && $this->amountPaid < $this->calculateTotal()) {
            // Keep user payment
        }
    }

    public function calculateSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function calculateTotal(): float
    {
        $total = $this->calculateSubtotal() - $this->discount;
        return max(0, $total);
    }

    public function calculateChange(): float
    {
        return max(0, $this->amountPaid - $this->calculateTotal());
    }

    public function processTransaction(TransactionService $transactionService, ReceiptService $receiptService): void
    {
        if (empty($this->cart)) {
            Notification::make()
                ->title('Keranjang masih kosong')
                ->warning()
                ->send();
            return;
        }

        $total = $this->calculateTotal();
        if ($this->amountPaid < $total) {
            Notification::make()
                ->title('Nominal pembayaran kurang')
                ->body('Uang yang dibayarkan harus minimal sama dengan total belanja.')
                ->danger()
                ->send();
            return;
        }

        try {
            // Format items array for TransactionService: [['product_id' => ..., 'quantity' => ...]]
            $items = array_values(array_map(function ($item) {
                return [
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                ];
            }, $this->cart));

            $transaction = $transactionService->createTransaction(
                items: $items,
                amountPaid: $this->amountPaid,
                discount: $this->discount,
                cashierId: Auth::id() ?? 1,
                paymentMethod: 'CASH'
            );

            $this->completedTransactionId = $transaction->id;
            $this->completedReceipt = $receiptService->generateCustomerReceipt($transaction);

            // Reset cart
            $this->cart = [];
            $this->amountPaid = 0;
            $this->discount = 0;

            Notification::make()
                ->title('Transaksi Berhasil!')
                ->body("No. Transaksi: {$transaction->transaction_number}. Kembalian: Rp " . number_format($transaction->change, 0, ',', '.'))
                ->success()
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal memproses transaksi')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function closeReceiptModal(): void
    {
        $this->completedTransactionId = null;
        $this->completedReceipt = null;
    }

    public function getViewData(): array
    {
        $categories = ProductCategory::withCount('products')->get();

        $productsQuery = Product::query()
            ->where('status', 'available')
            ->with('category');

        if ($this->selectedCategoryId) {
            $productsQuery->where('category_id', $this->selectedCategoryId);
        }

        if (! empty($this->searchQuery)) {
            $productsQuery->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        $products = $productsQuery->orderBy('name')->get();

        return [
            'categories' => $categories,
            'products' => $products,
            'subtotal' => $this->calculateSubtotal(),
            'total' => $this->calculateTotal(),
            'change' => $this->calculateChange(),
        ];
    }
}
