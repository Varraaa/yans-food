<?php

namespace App\Services;

use App\Models\CateringOrder;
use App\Models\CateringPayment;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Memproses pembayaran katering (DP atau Pelunasan) dengan Transaction Safety
     *
     * @param int $cateringOrderId
     * @param float $amount
     * @param string $paymentType CASH / DP / PELUNASAN
     * @param string $paymentMethod CASH / TRANSFER / QRIS
     * @param int|null $receivedBy User ID penerima
     * @param string|null $notes
     * @return CateringPayment
     * @throws Exception
     */
    public function recordCateringPayment(
        int $cateringOrderId,
        float $amount,
        string $paymentType,
        string $paymentMethod = 'CASH',
        ?int $receivedBy = null,
        ?string $notes = null
    ): CateringPayment {
        if ($amount <= 0) {
            throw new Exception("Nominal pembayaran harus lebih besar dari 0.");
        }

        DB::beginTransaction();

        try {
            $order = CateringOrder::lockForUpdate()->find($cateringOrderId);

            if (!$order) {
                throw new Exception("Pesanan katering tidak ditemukan.");
            }

            if ($order->status === 'CANCELLED') {
                throw new Exception("Tidak dapat menerima pembayaran untuk pesanan yang sudah dibatalkan.");
            }

            $currentPaid = (float) $order->payments()->sum('amount');
            $remaining = (float) $order->total - $currentPaid;

            // Sesuai aturan spesifikasi: Pembayaran yang melebihi sisa harus ditolak
            if ($amount > $remaining) {
                throw new Exception("Nominal pembayaran (Rp " . number_format($amount, 0, ',', '.') . ") melebihi sisa tagihan (Rp " . number_format($remaining, 0, ',', '.') . ").");
            }

            $paymentNumber = 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $payment = CateringPayment::create([
                'catering_order_id' => $order->id,
                'payment_number' => $paymentNumber,
                'payment_type' => $paymentType,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'payment_date' => now()->toDateString(),
                'received_by' => $receivedBy,
                'notes' => $notes,
            ]);

            // Hitung status pembayaran baru
            $newTotalPaid = $currentPaid + $amount;
            if ($newTotalPaid >= (float) $order->total) {
                $order->update(['payment_status' => 'PAID']);
            } elseif ($newTotalPaid > 0) {
                $order->update(['payment_status' => 'DP']);
            } else {
                $order->update(['payment_status' => 'UNPAID']);
            }

            DB::commit();

            return $payment;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
