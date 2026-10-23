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
        $query = Transaction::query()->with(['cashier', 'items'])->orderBy('transaction_date', 'desc')->orderBy('transaction_time', 'desc')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->date);
        }

        if ($request->filled('month') && $request->month !== 'all') {
            $query->where('transaction_date', 'like', $request->month . '%');
        }

        if ($request->filled('method') && in_array(strtoupper($request->method), ['CASH', 'QRIS'])) {
            $query->where('payment_method', strtoupper($request->method));
        }

        // Daftar riwayat bulan yang tersedia
        $currentMonthKey = now()->format('Y-m');
        $availableMonths = Transaction::completed()
            ->selectRaw("
                DATE_FORMAT(transaction_date, '%Y-%m') as month_key,
                COUNT(*) as tx_count,
                COALESCE(SUM(total), 0) as total_amount
            ")
            ->groupBy('month_key')
            ->orderByDesc('month_key')
            ->get()
            ->map(function ($item) use ($currentMonthKey) {
                try {
                    $date = \Carbon\Carbon::createFromFormat('Y-m', $item->month_key);
                    $label = $date->translatedFormat('F Y');
                    $short = $date->translatedFormat('M Y');
                } catch (\Throwable $e) {
                    $label = $item->month_key;
                    $short = $item->month_key;
                }
                return [
                    'key' => $item->month_key,
                    'label' => $label,
                    'short_label' => $short,
                    'count' => (int) $item->tx_count,
                    'total' => (float) $item->total_amount,
                    'is_current' => $item->month_key === $currentMonthKey,
                ];
            });

        $totalFilteredAmount = (float) (clone $query)->where('status', 'completed')->sum('total');
        $transactions = $query->paginate(30)->withQueryString();

        // Kelompokkan data transaksi per bulan (Y-m) untuk dijadikan section per bulan
        $groupedTransactions = $transactions->getCollection()->groupBy(function ($tx) {
            return \Carbon\Carbon::parse($tx->transaction_date)->format('Y-m');
        });

        return view('admin.transactions.index', compact(
            'transactions',
            'groupedTransactions',
            'availableMonths',
            'currentMonthKey',
            'totalFilteredAmount'
        ));
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
