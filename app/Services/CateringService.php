<?php

namespace App\Services;

use App\Models\CateringOrder;
use App\Models\CateringOrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class CateringService
{
    /**
     * Membuat pesanan katering terstruktur dengan Database Transaction Safety (COMMIT / ROLLBACK)
     *
     * @param array $customerData ['name', 'phone', 'address', 'event_date', 'event_time', 'purpose', 'notes']
     * @param array $items Array of ['product_id' => int, 'quantity' => int]
     * @param int|null $createdBy User ID admin/petugas jika diinput dari admin
     * @return CateringOrder
     * @throws Exception
     */
    public function createOrder(array $customerData, array $items, ?int $createdBy = null): CateringOrder
    {
        if (empty($items)) {
            throw new Exception("Pesanan katering harus memiliki minimal 1 menu.");
        }

        DB::beginTransaction();

        try {
            $subtotal = 0.00;
            $preparedItems = [];

            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new Exception("Menu dengan ID {$item['product_id']} tidak ditemukan.");
                }

                $qty = (int) $item['quantity'];
                if ($qty <= 0) {
                    throw new Exception("Kuantitas menu '{$product->name}' harus minimal 1.");
                }

                $itemSubtotal = $product->price * $qty;
                $subtotal += $itemSubtotal;

                $preparedItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $orderNumber = 'CAT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $order = CateringOrder::create([
                'order_number' => $orderNumber,
                'customer_name' => $customerData['name'],
                'customer_phone' => $customerData['phone'],
                'customer_address' => $customerData['address'],
                'event_date' => $customerData['event_date'],
                'event_time' => $customerData['event_time'],
                'event_purpose' => $customerData['purpose'] ?? null,
                'notes' => $customerData['notes'] ?? null,
                'subtotal' => $subtotal,
                'discount' => 0.00,
                'total' => $subtotal,
                'status' => 'PENDING',
                'payment_status' => 'UNPAID',
                'created_by' => $createdBy,
            ]);

            foreach ($preparedItems as $prep) {
                CateringOrderItem::create([
                    'catering_order_id' => $order->id,
                    'product_id' => $prep['product_id'],
                    'product_name' => $prep['product_name'],
                    'quantity' => $prep['quantity'],
                    'unit_price' => $prep['unit_price'],
                    'subtotal' => $prep['subtotal'],
                ]);
            }

            DB::commit();

            return $order->load('items');

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Generate URL WhatsApp dengan pesan terformat rapi untuk admin
     */
    public function generateWhatsAppUrl(CateringOrder $order, string $adminPhone = '6281234567890'): string
    {
        $message = "Halo Admin Yan's Food,\n";
        $message .= "Saya baru saja membuat pesanan katering melalui website:\n\n";
        $message .= "📋 No. Order: {$order->order_number}\n";
        $message .= "👤 Nama: {$order->customer_name}\n";
        $message .= "📅 Tanggal Acara: {$order->event_date->format('d/m/Y')}\n";
        $message .= "⏰ Jam Tiba: {$order->event_time}\n";
        $message .= "📍 Alamat: {$order->customer_address}\n";
        if ($order->event_purpose) {
            $message .= "🎯 Acara: {$order->event_purpose}\n";
        }
        $message .= "\nRincian Menu:\n";

        foreach ($order->items as $item) {
            $message .= "- {$item->product_name} x {$item->quantity} = Rp " . number_format($item->subtotal, 0, ',', '.') . "\n";
        }

        $message .= "\n💰 Estimasi Total: Rp " . number_format($order->total, 0, ',', '.') . "\n";
        if ($order->notes) {
            $message .= "📝 Catatan: {$order->notes}\n";
        }
        $message .= "\nMohon konfirmasi pesanan saya. Terima kasih!";

        return "https://wa.me/{$adminPhone}?text=" . rawurlencode($message);
    }
}
