<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query()->with(['cashier', 'items'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('transaction_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->date);
        }

        if ($request->filled('method') && $request->method !== 'all') {
            $query->where('payment_method', $request->method);
        }

        $transactions = $query->paginate(15)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id, ReceiptService $receiptService)
    {
        $transaction = Transaction::with(['cashier', 'items.product'])->findOrFail($id);
        $receipt = $receiptService->generateCustomerReceipt($transaction);

        return view('admin.transactions.show', compact('transaction', 'receipt'));
    }
}
