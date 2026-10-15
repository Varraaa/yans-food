<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringOrder;
use App\Models\Transaction;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function index(ReportService $reportService)
    {
        $kpis = $reportService->getDashboardKpis();

        $upcomingCatering = CateringOrder::query()
            ->whereNotIn('status', ['COMPLETED', 'CANCELLED'])
            ->orderBy('event_date', 'asc')
            ->orderBy('event_time', 'asc')
            ->limit(5)
            ->get();

        $latestTransactions = Transaction::query()
            ->where('status', 'completed')
            ->with('cashier')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('transaction_time', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('kpis', 'upcomingCatering', 'latestTransactions'));
    }
}
