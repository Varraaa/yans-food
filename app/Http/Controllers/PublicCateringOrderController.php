<?php

namespace App\Http\Controllers;

use App\Models\CateringOrder;
use App\Models\Product;
use App\Services\CateringService;
use Illuminate\Http\Request;

class PublicCateringOrderController extends Controller
{
    public function store(Request $request, CateringService $cateringService)
    {
        // Honeypot spam protection (§6.5)
        if ($request->filled('website_trap') || $request->filled('website_url')) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Spam detected.'], 422);
            }
            return redirect()->back();
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'event_date' => 'required|date',
            'event_time' => 'required|string',
            'event_purpose' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'package_type' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ]);

        $items = [];
        if (! empty($validated['items']) && is_array($validated['items'])) {
            foreach ($validated['items'] as $it) {
                if (! empty($it['product_id']) && ! empty($it['quantity'])) {
                    $items[] = [
                        'product_id' => (int) $it['product_id'],
                        'quantity' => (int) $it['quantity'],
                    ];
                }
            }
        }

        if (empty($items)) {
            if (! empty($validated['product_id']) && ! empty($validated['quantity'])) {
                $items[] = [
                    'product_id' => (int) $validated['product_id'],
                    'quantity' => (int) $validated['quantity'],
                ];
            } else {
                // Find default catering product or first available product
                $defaultProduct = Product::where('status', 'available')->first();
                $qty = ! empty($validated['quantity']) ? (int) $validated['quantity'] : 20;

                if ($defaultProduct) {
                    $items[] = [
                        'product_id' => $defaultProduct->id,
                        'quantity' => $qty,
                    ];
                }
            }
        }

        $notes = $validated['notes'] ?? '';
        if (! empty($validated['package_type'])) {
            $notes = "[Paket: {$validated['package_type']}] " . $notes;
        }

        $order = $cateringService->createOrder(
            customerData: [
                'name' => $validated['customer_name'],
                'phone' => $validated['customer_phone'],
                'address' => $validated['customer_address'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'purpose' => $validated['event_purpose'] ?? ($validated['package_type'] ?? 'Acara Spesial'),
                'notes' => trim($notes),
            ],
            items: $items,
            createdBy: null
        );

        $waUrl = $cateringService->generateWhatsAppUrl($order);
        $successUrl = route('pesan.katering.sukses', ['order_number' => $order->order_number]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan katering berhasil dicatat!',
                'order_number' => $order->order_number,
                'whatsapp_url' => $waUrl,
                'redirect_url' => $successUrl,
            ]);
        }

        return redirect()->to($successUrl);
    }

    public function success(string $order_number, CateringService $cateringService)
    {
        $order = CateringOrder::with('items')->where('order_number', $order_number)->firstOrFail();
        $waUrl = $cateringService->generateWhatsAppUrl($order);

        return view('pages.pesan-sukses', compact('order', 'waUrl'));
    }
}

