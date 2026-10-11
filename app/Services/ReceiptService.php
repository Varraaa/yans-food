<?php

namespace App\Services;

use App\Models\CateringOrder;
use App\Models\Transaction;

class ReceiptService
{
    /**
     * Format struk transaksi POS kasir
     */
    public function formatPosReceipt(Transaction $transaction, int $width = 32): string
    {
        $line = str_repeat('-', $width);
        $doubleLine = str_repeat('=', $width);

        $out = "";
        $out .= $this->center("YAN'S FOOD", $width) . "\n";
        $out .= $this->center("Dapur Kuliner Rumahan", $width) . "\n";
        $out .= $this->center("Jl. Melati No. 14, Jaksel", $width) . "\n";
        $out .= $doubleLine . "\n";

        $out .= "No: " . $transaction->transaction_number . "\n";
        $out .= "Tgl: " . $transaction->transaction_date->format('d/m/Y') . " " . substr($transaction->transaction_time, 0, 5) . "\n";
        $out .= "Kasir: " . ($transaction->cashier?->name ?? 'Kasir') . "\n";
        $out .= $line . "\n";

        foreach ($transaction->items as $item) {
            $out .= $item->product_name . "\n";
            $qtyPrice = "  " . $item->quantity . " x " . number_format($item->unit_price, 0, ',', '.');
            $subtotalStr = number_format($item->subtotal, 0, ',', '.');
            $out .= $this->justify($qtyPrice, $subtotalStr, $width) . "\n";
        }

        $out .= $line . "\n";
        $out .= $this->justify("Subtotal:", "Rp " . number_format($transaction->subtotal, 0, ',', '.'), $width) . "\n";
        if ($transaction->discount > 0) {
            $out .= $this->justify("Diskon:", "-Rp " . number_format($transaction->discount, 0, ',', '.'), $width) . "\n";
        }
        $out .= $this->justify("TOTAL:", "Rp " . number_format($transaction->total, 0, ',', '.'), $width) . "\n";
        $out .= $this->justify("Metode:", $transaction->payment_method, $width) . "\n";
        $out .= $this->justify("Bayar:", "Rp " . number_format($transaction->amount_paid, 0, ',', '.'), $width) . "\n";
        $out .= $this->justify("Kembali:", "Rp " . number_format($transaction->change, 0, ',', '.'), $width) . "\n";

        $out .= $doubleLine . "\n";
        $out .= $this->center("Terima Kasih!", $width) . "\n";
        $out .= $this->center("Selamat Menikmati", $width) . "\n\n\n";

        return $out;
    }

    /**
     * Format Kitchen Note (Catatan Dapur / Katering tanpa harga)
     */
    public function formatKitchenNote(CateringOrder $order, int $width = 32): string
    {
        $doubleLine = str_repeat('=', $width);
        $line = str_repeat('-', $width);

        $out = "";
        $out .= $this->center("KITCHEN ORDER NOTE", $width) . "\n";
        $out .= $this->center("YAN'S FOOD CATERING", $width) . "\n";
        $out .= $doubleLine . "\n";

        $out .= "Order: " . $order->order_number . "\n";
        $out .= "Pelanggan: " . $order->customer_name . "\n";
        $out .= "Acara: " . ($order->event_purpose ?? '-') . "\n";
        $out .= "Tgl/Jam: " . $order->event_date->format('d/m/Y') . " " . $order->event_time . "\n";
        $out .= $line . "\n";
        $out .= "MENU PESANAN:\n";

        foreach ($order->items as $item) {
            $out .= "[ ] " . $item->quantity . "x " . $item->product_name . "\n";
        }

        if ($order->notes) {
            $out .= $line . "\n";
            $out .= "CATATAN KHUSUS:\n";
            $out .= wordwrap($order->notes, $width, "\n") . "\n";
        }

        $out .= $doubleLine . "\n\n\n";

        return $out;
    }

    private function center(string $text, int $width): string
    {
        $len = strlen($text);
        if ($len >= $width) return $text;
        $left = (int) floor(($width - $len) / 2);
        return str_repeat(' ', $left) . $text;
    }

    private function justify(string $left, string $right, int $width): string
    {
        $space = $width - strlen($left) - strlen($right);
        if ($space < 1) $space = 1;
        return $left . str_repeat(' ', $space) . $right;
    }
}
