<?php

namespace App\Services;

use App\Models\CateringOrder;
use App\Models\Transaction;

class ReceiptService
{
    /**
     * Generate customer receipt structured data for modals and views
     */
    public function generateCustomerReceipt(Transaction $transaction): array
    {
        $transaction->loadMissing(['items', 'cashier']);

        $settings = [];
        $settingsPath = storage_path('app/settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true) ?? [];
        }

        $storeName = $settings['store_name'] ?? "Yan's Food";
        $storeAddress = $settings['store_address'] ?? 'Jl. Babakan Tarogong No. 12, Bandung';
        $storePhone = $settings['store_phone'] ?? '081234567890';

        $items = [];
        foreach ($transaction->items as $item) {
            $items[] = [
                'name' => $item->product_name,
                'qty' => (int) $item->quantity,
                'price' => (float) $item->unit_price,
                'subtotal' => (float) $item->subtotal,
            ];
        }

        $dateStr = $transaction->transaction_date instanceof \DateTimeInterface 
            ? $transaction->transaction_date->format('d/m/Y') 
            : date('d/m/Y', strtotime($transaction->transaction_date));

        $timeStr = (strlen($transaction->transaction_time) >= 5 ? substr($transaction->transaction_time, 0, 5) : $transaction->transaction_time) . ' WIB';

        return [
            'header' => [
                'store_name' => $storeName,
                'address' => $storeAddress,
                'phone' => $storePhone,
            ],
            'order_info' => [
                'number' => $transaction->transaction_number,
                'cashier' => $transaction->cashier?->name ?? 'Kasir Utama',
                'date' => $dateStr,
                'time' => $timeStr,
            ],
            'items' => $items,
            'summary' => [
                'subtotal' => (float) $transaction->subtotal,
                'discount' => (float) $transaction->discount,
                'total' => (float) $transaction->total,
            ],
            'payment' => [
                'method' => $transaction->payment_method,
                'paid' => (float) $transaction->amount_paid,
                'change' => (float) $transaction->change,
            ],
            'footer' => [
                'message' => 'Terima kasih atas kunjungan Anda!',
                'sub_message' => 'Sajian Rumahan Penuh Kehangatan',
            ],
            'raw_thermal' => $this->formatPosReceipt($transaction),
        ];
    }

    /**
     * Format struk transaksi POS kasir
     */
    public function formatPosReceipt(Transaction $transaction, int $width = 32): string
    {
        $settings = [];
        $settingsPath = storage_path('app/settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true) ?? [];
        }

        $storeName = strtoupper($settings['store_name'] ?? "YAN'S FOOD");
        $storeAddress = $settings['store_address'] ?? 'Jl. Babakan Tarogong No. 12, Bandung';

        $line = str_repeat('-', $width);
        $doubleLine = str_repeat('=', $width);

        $out = "";
        $out .= $this->center($storeName, $width) . "\n";
        $out .= $this->center("Dapur Kuliner Rumahan", $width) . "\n";
        $out .= $this->center($storeAddress, $width) . "\n";
        $out .= $doubleLine . "\n";

        $dateStr = $transaction->transaction_date instanceof \DateTimeInterface 
            ? $transaction->transaction_date->format('d/m/Y') 
            : date('d/m/Y', strtotime($transaction->transaction_date));

        $out .= "No: " . $transaction->transaction_number . "\n";
        $out .= "Tgl: " . $dateStr . " " . substr($transaction->transaction_time, 0, 5) . " WIB\n";
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
