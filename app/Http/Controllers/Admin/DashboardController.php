<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function index(ReportService $reportService)
    {
        $kpis = $reportService->getDashboardKpis();

        $lowStockProducts = Product::query()
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        $latestTransactions = Transaction::query()
            ->where('status', 'completed')
            ->with('cashier')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('transaction_time', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('kpis', 'lowStockProducts', 'latestTransactions'));
    }
}
