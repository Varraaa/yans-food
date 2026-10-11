<?php

namespace App\Services;

use App\Models\CateringOrder;
use App\Models\CateringPayment;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * KPI Dashboard Ringkasan Hari Ini
     */
    public function getDashboardKpis(): array
    {
        $today = Carbon::today()->toDateString();

        $revenueToday = (float) Transaction::where('status', 'completed')
            ->whereDate('transaction_date', $today)
            ->sum('total');

        $transactionsToday = Transaction::where('status', 'completed')
            ->whereDate('transaction_date', $today)
            ->count();

        $cateringIncomeToday = (float) CateringPayment::whereDate('payment_date', $today)
            ->sum('amount');

        $expensesToday = (float) Expense::where('status', 'APPROVED')
            ->whereDate('expense_date', $today)
            ->sum('amount');

        $simpleNetProfitToday = ($revenueToday + $cateringIncomeToday) - $expensesToday;

        $cateringUnpaidCount = CateringOrder::whereIn('payment_status', ['UNPAID', 'DP'])->count();
        $cateringCompletedCount = CateringOrder::where('status', 'COMPLETED')->count();

        return [
            'revenue_today' => $revenueToday,
            'transactions_today' => $transactionsToday,
            'catering_income_today' => $cateringIncomeToday,
            'expenses_today' => $expensesToday,
            'simple_net_profit_today' => $simpleNetProfitToday,
            'catering_unpaid_count' => $cateringUnpaidCount,
            'catering_completed_count' => $cateringCompletedCount,
        ];
    }

    /**
     * Laporan Penghasilan Riil Katering (dari catering_payments)
     */
    public function getCateringIncomeReport(?string $startDate = null, ?string $endDate = null): array
    {
        $query = CateringPayment::with('order');

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $totalIncome = $payments->sum('amount');
        $paymentCount = $payments->count();
        $ordersCount = $payments->pluck('catering_order_id')->unique()->count();

        return [
            'summary' => [
                'total_income' => (float) $totalIncome,
                'payment_count' => $paymentCount,
                'orders_count' => $ordersCount,
            ],
            'payments' => $payments,
        ];
    }

    /**
     * Laporan Penjualan POS Reguler
     */
    public function getSalesReport(?string $startDate = null, ?string $endDate = null, ?int $productId = null): array
    {
        $query = Transaction::where('status', 'completed')->with(['cashier', 'items']);

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        if ($productId) {
            $query->whereHas('items', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->orderBy('transaction_time', 'desc')->get();

        $totalRevenue = $transactions->sum('total');
        $txCount = $transactions->count();
        $averageTx = $txCount > 0 ? $totalRevenue / $txCount : 0;

        // Breakdown penjualan per produk
        $productSalesQuery = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed');

        if ($startDate && $endDate) {
            $productSalesQuery->whereBetween('transactions.transaction_date', [$startDate, $endDate]);
        }

        $productSales = $productSalesQuery->select(
            'transaction_items.product_name',
            DB::raw('SUM(transaction_items.quantity) as total_quantity'),
            DB::raw('COUNT(DISTINCT transactions.id) as transaction_count'),
            DB::raw('SUM(transaction_items.subtotal) as total_sales')
        )
        ->groupBy('transaction_items.product_name')
        ->orderByDesc('total_quantity')
        ->get();

        return [
            'summary' => [
                'total_revenue' => (float) $totalRevenue,
                'transaction_count' => $txCount,
                'average_transaction' => (float) $averageTx,
            ],
            'transactions' => $transactions,
            'product_sales' => $productSales,
        ];
    }

    /**
     * Laporan Khusus Catering
     */
    public function getCateringReport(?string $startDate = null, ?string $endDate = null): array
    {
        $query = CateringOrder::with('items');

        if ($startDate && $endDate) {
            $query->whereBetween('event_date', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('event_date', 'desc')->get();

        $totalOrderValue = $orders->sum('total');
        $orderCount = $orders->count();

        // Realisasi uang masuk katering
        $paymentsQuery = CateringPayment::query();
        if ($startDate && $endDate) {
            $paymentsQuery->whereBetween('payment_date', [$startDate, $endDate]);
        }
        $totalIncome = $paymentsQuery->sum('amount');

        // Status breakdown
        $statusBreakdown = [
            'PENDING' => $orders->where('status', 'PENDING')->count(),
            'CONFIRMED' => $orders->where('status', 'CONFIRMED')->count(),
            'IN_PROGRESS' => $orders->where('status', 'IN_PROGRESS')->count(),
            'READY' => $orders->where('status', 'READY')->count(),
            'DELIVERING' => $orders->where('status', 'DELIVERING')->count(),
            'COMPLETED' => $orders->where('status', 'COMPLETED')->count(),
            'CANCELLED' => $orders->where('status', 'CANCELLED')->count(),
        ];

        return [
            'summary' => [
                'total_order_value' => (float) $totalOrderValue,
                'total_income' => (float) $totalIncome,
                'order_count' => $orderCount,
            ],
            'orders' => $orders,
            'statusBreakdown' => $statusBreakdown,
        ];
    }
}
