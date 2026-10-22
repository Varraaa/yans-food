<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Printer;
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

        if ($request->filled('method') && in_array(strtoupper($request->method), ['CASH', 'QRIS'])) {
            $query->where('payment_method', strtoupper($request->method));
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

    public function receipt($id, ReceiptService $receiptService)
    {
        $transaction = Transaction::with(['cashier', 'items.product'])->findOrFail($id);
        $receipt = $receiptService->generateCustomerReceipt($transaction);

        // Ambil pengaturan lebar kertas printer yang aktif bila ada
        $paperWidth = '58mm';
        try {
            $activePrinter = Printer::where('status', 'active')->first();
            if ($activePrinter && !empty($activePrinter->paper_width)) {
                $paperWidth = $activePrinter->paper_width;
            }
        } catch (\Throwable $e) {
            // fallback default
        }

        return view('admin.transactions.receipt', compact('transaction', 'receipt', 'paperWidth'));
    }
}
