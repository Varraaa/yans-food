<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PosCheckoutService
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    /**
     * Memvalidasi dan menghitung ulang keranjang langsung dari database (Server as single source of truth)
     */
    public function buildCart(array $items, float $discount = 0.0): array
    {
        if (empty($items)) {
            throw new Exception("Keranjang transaksi kosong.");
        }

        $subtotal = 0.0;
        $validatedItems = [];
        $totalQtyPerProduct = [];

        foreach ($items as $item) {
            $pId = (int) ($item['product_id'] ?? 0);
            $q = (int) ($item['quantity'] ?? 0);
            $totalQtyPerProduct[$pId] = ($totalQtyPerProduct[$pId] ?? 0) + $q;
        }

        foreach ($items as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);

            if ($qty <= 0) {
                throw new Exception("Kuantitas produk tidak valid.");
            }

            $product = Product::find($productId);
            if (!$product) {
                throw new Exception("Produk dengan ID {$productId} tidak ditemukan.");
            }

            if ($product->status === 'unavailable') {
                throw new Exception("Produk '{$product->name}' sedang tidak tersedia untuk dijual.");
            }

            $totalRequested = $totalQtyPerProduct[$productId] ?? $qty;
            if ($product->stock < $totalRequested) {
                throw new Exception("Stok untuk produk '{$product->name}' tidak mencukupi (Diminta: {$totalRequested}, Tersisa: {$product->stock}).");
            }

            $unitPrice = (float) $product->price;
            $itemSubtotal = $unitPrice * $qty;
            $subtotal += $itemSubtotal;

            $displayName = $product->name;
            if (!empty($item['variant'])) {
                $displayName = preg_replace('/\s*\(\s*Hangat\s*\/\s*Dingin\s*\)/i', ' (' . $item['variant'] . ')', $displayName);
            }

            $validatedItems[] = [
                'product_id' => $product->id,
                'name' => $displayName,
                'variant' => $item['variant'] ?? null,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'subtotal' => $itemSubtotal,
            ];
        }

        $total = max(0.0, $subtotal - $discount);

        return [
            'items' => $validatedItems,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ];
    }

    /**
     * Memproses pembayaran Cash
     */
    public function payCash(array $items, float $amountPaid, ?int $cashierId, float $discount = 0.0, ?string $customerName = null): Transaction
    {
        return $this->transactionService->createTransaction(
            items: $items,
            amountPaid: $amountPaid,
            cashierId: $cashierId,
            discount: $discount,
            paymentMethod: PaymentMethod::CASH->value,
            customerName: $customerName
        );
    }

    /**
     * Menyiapkan sesi pembayaran QRIS (TTL 15 menit)
     */
    public function prepareQris(array $items, int $cashierId, float $discount = 0.0, ?string $customerName = null): array
    {
        $qrisPath = Setting::get('qris_image_path');
        if (empty($qrisPath)) {
            // Cek juga di settings.json sebagai fallback
            $settingsFile = storage_path('app/settings.json');
            if (file_exists($settingsFile)) {
                $saved = json_decode(file_get_contents($settingsFile), true) ?? [];
                $qrisPath = $saved['qris_image_path'] ?? null;
            }
        }

        if (empty($qrisPath) || (!file_exists(public_path($qrisPath)) && !file_exists(storage_path('app/public/' . $qrisPath)))) {
            if (file_exists(public_path('images/qris/qris-yansfood.jpeg'))) {
                $qrisPath = 'images/qris/qris-yansfood.jpeg';
            }
        }

        if (empty($qrisPath)) {
            throw new Exception("Gambar QR code QRIS belum diunggah di Pengaturan toko.");
        }

        $cart = $this->buildCart($items, $discount);
        $token = (string) Str::uuid();

        $sessionData = [
            'token' => $token,
            'cashier_id' => $cashierId,
            'customer_name' => $customerName,
            'items' => $items,
            'validated_items' => $cart['items'],
            'subtotal' => $cart['subtotal'],
            'discount' => $cart['discount'],
            'total' => $cart['total'],
            'created_at' => now()->toIso8601String(),
            'transaction_id' => null,
        ];

        // Cache 15 menit
        Cache::put("pos:qris:{$token}", $sessionData, now()->addMinutes(15));

        return [
            'token' => $token,
            'total' => $cart['total'],
        ];
    }

    /**
     * Mengambil data sesi QRIS
     */
    public function getQrisSession(string $token): ?array
    {
        return Cache::get("pos:qris:{$token}");
    }

    /**
     * Konfirmasi pembayaran QRIS (Tombol Next) - Idempoten & atomic
     */
    public function confirmQris(string $token, int $cashierId): Transaction
    {
        $session = $this->getQrisSession($token);

        if (!$session) {
            throw new Exception("Sesi pembayaran QRIS sudah kedaluwarsa atau tidak ditemukan. Silakan ulangi dari kasir.");
        }

        // Idempoten: Jika sudah pernah dibuat, kembalikan transaksi yang ada
        if (!empty($session['transaction_id'])) {
            $existing = Transaction::find($session['transaction_id']);
            if ($existing) {
                return $existing;
            }
        }

        // Verifikasi kasir jika ada (fallback ke cashier yang login saat ini)
        $effectiveCashierId = $cashierId ?: ($session['cashier_id'] ?? 1);

        // Hitung ulang harga terkini dari DB untuk memastikan harga valid
        $currentCart = $this->buildCart($session['items'], (float) ($session['discount'] ?? 0));

        // Buat transaksi dengan QRIS
        $transaction = $this->transactionService->createTransaction(
            items: $session['items'],
            amountPaid: $currentCart['total'],
            cashierId: $effectiveCashierId,
            discount: (float) ($session['discount'] ?? 0),
            paymentMethod: PaymentMethod::QRIS->value,
            customerName: $session['customer_name'] ?? null
        );

        // Tandai sesi sebagai telah selesai (idempotensi)
        $session['transaction_id'] = $transaction->id;
        Cache::put("pos:qris:{$token}", $session, now()->addMinutes(15));

        return $transaction;
    }

    /**
     * Membatalkan sesi QRIS dan mengembalikan data keranjang untuk dipulihkan di kasir
     */
    public function cancelQris(string $token): array
    {
        $session = $this->getQrisSession($token);
        Cache::forget("pos:qris:{$token}");

        return $session['items'] ?? [];
    }
}
