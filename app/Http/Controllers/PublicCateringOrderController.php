<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CateringService;
use Illuminate\Http\Request;

class PublicCateringOrderController extends Controller
{
    public function store(Request $request, CateringService $cateringService)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_purpose' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'package_type' => 'nullable|string',
        ]);

        // If specific product selected, create item array
        $items = [];
        if (! empty($validated['product_id']) && ! empty($validated['quantity'])) {
            $items[] = [
                'product_id' => (int) $validated['product_id'],
                'quantity' => (int) $validated['quantity'],
            ];
        } else {
            // Find default catering package product or first available product
            $defaultProduct = Product::where('status', 'available')->first();
            $qty = ! empty($validated['quantity']) ? (int) $validated['quantity'] : 20;

            if ($defaultProduct) {
                $items[] = [
                    'product_id' => $defaultProduct->id,
                    'quantity' => $qty,
                ];
            }
        }

        $notes = $validated['notes'] ?? '';
        if (! empty($validated['package_type'])) {
            $notes = "[Paket: {$validated['package_type']}] " . $notes;
        }

        $order = $cateringService->createOrder(
            customerData: [
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'event_purpose' => $validated['event_purpose'] ?? ($validated['package_type'] ?? 'Acara Keluarga / Kantor'),
                'notes' => trim($notes),
            ],
            items: $items,
            createdBy: null
        );

        $waUrl = $cateringService->generateWhatsAppUrl($order);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan katering berhasil dicatat!',
                'order_number' => $order->order_number,
                'whatsapp_url' => $waUrl,
            ]);
        }

        return redirect()->away($waUrl);
    }
}
