<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringOrder;
use Illuminate\Http\Request;

class CateringOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = CateringOrder::with(['items', 'payments'])->orderBy('event_date', 'desc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(12)->withQueryString();

        return view('admin.catering.orders.index', compact('orders'));
    }

    public function show(CateringOrder $order)
    {
        $order->load(['items.product', 'payments']);
        $totalPaid = (float) $order->payments->sum('amount');
        $unpaid = max(0, (float) $order->total - $totalPaid);

        return view('admin.catering.orders.show', compact('order', 'totalPaid', 'unpaid'));
    }

    public function updateStatus(Request $request, CateringOrder $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:PENDING,CONFIRMED,IN_PROGRESS,READY,DELIVERING,COMPLETED,CANCELLED'],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui menjadi {$validated['status']}!");
    }
}
