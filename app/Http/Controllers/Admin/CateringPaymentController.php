<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringOrder;
use App\Models\CateringPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateringPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = CateringPayment::with('order')->orderBy('payment_date', 'desc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('payment_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('order', function ($o) use ($request) {
                      $o->where('order_number', 'like', '%' . $request->search . '%')
                        ->orWhere('customer_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('payment_type') && $request->payment_type !== 'all') {
            $query->where('payment_type', $request->payment_type);
        }

        $payments = $query->paginate(15)->withQueryString();

        return view('admin.catering.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $orders = CateringOrder::whereIn('payment_status', ['UNPAID', 'DP'])
            ->whereNotIn('status', ['CANCELLED'])
            ->orderBy('event_date', 'asc')
            ->get();

        $selectedOrderId = $request->query('order_id');

        return view('admin.catering.payments.create', compact('orders', 'selectedOrderId'));
    }

    public function store(Request $request, PaymentService $paymentService)
    {
        $validated = $request->validate([
            'catering_order_id' => ['required', 'exists:catering_orders,id'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'payment_type' => ['required', 'in:DP,PELUNASAN,CASH'],
            'payment_method' => ['required', 'in:CASH,TRANSFER,QRIS'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $payment = $paymentService->recordCateringPayment(
                cateringOrderId: (int) $validated['catering_order_id'],
                amount: (float) $validated['amount'],
                paymentType: $validated['payment_type'],
                paymentMethod: $validated['payment_method'],
                receivedBy: Auth::id() ?? 1,
                notes: $validated['notes'] ?? null
            );

            return redirect()->route('admin.catering.orders.show', $validated['catering_order_id'])
                ->with('success', "Pembayaran sebesar Rp " . number_format($payment->amount, 0, ',', '.') . " berhasil dicatat ({$payment->payment_number})!");
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
