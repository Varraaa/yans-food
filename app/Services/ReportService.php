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
    public function getCateringIncomeReport(?string $startDate = null, ?string $endDate = null, ?string $paymentType = null, ?string $paymentMethod = null): array
    {
        $query = CateringPayment::with('order');

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        if ($paymentType && $paymentType !== 'all') {
            $query->where('payment_type', $paymentType);
        }

        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where('payment_method', $paymentMethod);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $totalIncome = (float) $payments->sum('amount');
        $dpIncome = (float) $payments->where('payment_type', 'DP')->sum('amount');
        $pelunasanIncome = (float) $payments->where('payment_type', 'PELUNASAN')->sum('amount');
        $paymentCount = $payments->count();
        $ordersCount = $payments->pluck('catering_order_id')->unique()->count();

        return [
            'summary' => [
                'total_income' => $totalIncome,
                'dp_income' => $dpIncome,
                'pelunasan_income' => $pelunasanIncome,
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

        $totalRevenue = (float) $transactions->sum('total');
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
                'total_revenue' => $totalRevenue,
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

        $totalOrderValue = (float) $orders->sum('total');
        $orderCount = $orders->count();

        // Realisasi uang masuk katering
        $paymentsQuery = CateringPayment::query();
        if ($startDate && $endDate) {
            $paymentsQuery->whereBetween('payment_date', [$startDate, $endDate]);
        }
        $totalIncome = (float) $paymentsQuery->sum('amount');

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
                'total_order_value' => $totalOrderValue,
                'total_income' => $totalIncome,
                'order_count' => $orderCount,
            ],
            'orders' => $orders,
            'status_breakdown' => $statusBreakdown,
            'statusBreakdown' => $statusBreakdown,
        ];
    }

    /**
     * Laporan Laba Rugi & Arus Kas (Financial Summary)
     */
    public function getFinancialSummaryReport(?string $startDate = null, ?string $endDate = null): array
    {
        // 1. Omset POS
        $posQuery = Transaction::where('status', 'completed');
        if ($startDate && $endDate) {
            $posQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        }
        $posRevenue = (float) $posQuery->sum('total');
        $posCount = $posQuery->count();

        // 2. Realisasi Uang Masuk Katering (DP + Pelunasan)
        $cateringPaymentQuery = CateringPayment::query();
        if ($startDate && $endDate) {
            $cateringPaymentQuery->whereBetween('payment_date', [$startDate, $endDate]);
        }
        $cateringIncome = (float) $cateringPaymentQuery->sum('amount');
        $cateringPaymentCount = $cateringPaymentQuery->count();

        // Total Pendapatan Kas Masuk
        $totalGrossIncome = $posRevenue + $cateringIncome;

        // 3. Pengeluaran Dapur / Operasional yang Disetujui
        $expenseQuery = Expense::where('expenses.status', 'APPROVED');
        if ($startDate && $endDate) {
            $expenseQuery->whereBetween('expenses.expense_date', [$startDate, $endDate]);
        }
        $totalExpenses = (float) $expenseQuery->sum('expenses.amount');
        $expenseCount = $expenseQuery->count();

        // Pengeluaran per Kategori
        $expensesByCategory = (clone $expenseQuery)
            ->leftJoin('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
            ->select(
                DB::raw('COALESCE(expense_categories.name, "Operasional") as category_name'),
                DB::raw('SUM(expenses.amount) as total_amount'),
                DB::raw('COUNT(expenses.id) as count')
            )
            ->groupBy(DB::raw('COALESCE(expense_categories.name, "Operasional")'))
            ->orderByDesc('total_amount')
            ->get();

        // 4. Laba Bersih Operasional
        $netProfit = $totalGrossIncome - $totalExpenses;
        $profitMargin = $totalGrossIncome > 0 ? ($netProfit / $totalGrossIncome) * 100 : 0;

        return [
            'pos_revenue' => $posRevenue,
            'pos_count' => $posCount,
            'catering_income' => $cateringIncome,
            'catering_payment_count' => $cateringPaymentCount,
            'total_gross_income' => $totalGrossIncome,
            'total_expenses' => $totalExpenses,
            'expense_count' => $expenseCount,
            'net_profit' => $netProfit,
            'profit_margin' => round($profitMargin, 1),
            'expenses_by_category' => $expensesByCategory,
        ];
    }
}
