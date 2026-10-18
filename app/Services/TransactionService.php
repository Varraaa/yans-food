<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Memproses transaksi POS Kasir dengan Database Transaction Safety (BEGIN -> COMMIT / ROLLBACK)
     *
     * @param array $items Array of ['product_id' => int, 'quantity' => int]
     * @param float $amountPaid Uang yang dibayarkan pelanggan
     * @param int|null $cashierId User ID kasir
     * @param float $discount Diskon transaksi (default 0)
     * @param string $paymentMethod CASH / QRIS / TRANSFER
     * @return Transaction
     * @throws Exception
     */
    public function createTransaction(
        array $items,
        float $amountPaid,
        ?int $cashierId = null,
        float $discount = 0.00,
        string $paymentMethod = 'CASH'
    ): Transaction {
        if (empty($items)) {
            throw new Exception("Keranjang transaksi kosong.");
        }

        // ==========================================
        // 1. DATABASE TRANSACTION: BEGIN TRANSACTION
        // ==========================================
        DB::beginTransaction();

        try {
            $subtotal = 0.00;
            $preparedItems = [];

            // Validasi & Hitung Ulang Harga di Server-Side (Server is single source of truth)
            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    throw new Exception("Produk dengan ID {$item['product_id']} tidak ditemukan.");
                }

                if ($product->status === 'unavailable') {
                    throw new Exception("Produk '{$product->name}' sedang tidak tersedia untuk dijual.");
                }

                $qty = (int) $item['quantity'];
                if ($qty <= 0) {
                    throw new Exception("Kuantitas untuk produk '{$product->name}' harus lebih dari 0.");
                }

                if ($product->stock < $qty) {
                    throw new Exception("Stok untuk produk '{$product->name}' tidak mencukupi (Tersisa: {$product->stock}).");
                }

                $itemSubtotal = $product->price * $qty;
                $subtotal += $itemSubtotal;

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $total = max(0.00, $subtotal - $discount);

            if ($amountPaid < $total) {
                throw new Exception("Jumlah bayar (Rp " . number_format($amountPaid, 0, ',', '.') . ") kurang dari total tagihan (Rp " . number_format($total, 0, ',', '.') . ").");
            }

            $change = $amountPaid - $total;

            // Generate Transaction Number Unik (Format: TR-YYYYMMDD-XXXX)
            $transactionNumber = 'TR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            // Simpan Data Transaksi
            $transaction = Transaction::create([
                'transaction_number' => $transactionNumber,
                'transaction_date' => now()->toDateString(),
                'transaction_time' => now()->toTimeString(),
                'cashier_id' => $cashierId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $paymentMethod,
                'amount_paid' => $amountPaid,
                'change' => $change,
                'status' => 'completed',
            ]);

            // Simpan Snapshot Item Transaksi & Potong Stok
            foreach ($preparedItems as $prep) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $prep['product']->id,
                    'product_name' => $prep['product']->name, // Snapshot nama historis
                    'quantity' => $prep['quantity'],
                    'unit_price' => $prep['unit_price'],       // Snapshot harga historis
                    'subtotal' => $prep['subtotal'],
                ]);

                // Potong stok via PHP hanya jika database trigger MySQL belum ada/tidak aktif
                $hasTrigger = false;
                if (DB::getDriverName() === 'mysql') {
                    try {
                        $hasTrigger = DB::table('information_schema.TRIGGERS')
                            ->where('TRIGGER_SCHEMA', DB::getDatabaseName())
                            ->where('TRIGGER_NAME', 'trg_after_transaction_item_insert')
                            ->exists();
                    } catch (\Throwable $e) {}
                }

                if (!$hasTrigger) {
                    $prep['product']->decrement('stock', $prep['quantity']);
                }
            }

            // ==========================================
            // 2. DATABASE TRANSACTION: COMMIT
            // ==========================================
            DB::commit();

            return $transaction->load('items');

        } catch (Exception $e) {
            // ==========================================
            // 3. DATABASE TRANSACTION: ROLLBACK
            // ==========================================
            DB::rollBack();
            throw $e;
        }
    }
}
