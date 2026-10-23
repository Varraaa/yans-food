<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * KPI Dashboard Ringkasan Hari Ini (POS & Keuangan)
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

        $expensesToday = (float) Expense::where('status', 'APPROVED')
            ->whereDate('expense_date', $today)
            ->sum('amount');

        $simpleNetProfitToday = $revenueToday - $expensesToday;

        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        return [
            'revenue_today' => $revenueToday,
            'transactions_today' => $transactionsToday,
            'expenses_today' => $expensesToday,
            'simple_net_profit_today' => $simpleNetProfitToday,
            'total_products' => $totalProducts,
            'low_stock_count' => $lowStockCount,
        ];
    }

    /**
     * Laporan 3 Catatan Metode Pembayaran POS (Cash, QRIS, Total Gabungan) & Rincian Harian (§12)
     */
    public function getPaymentMethodReport(?string $startDate = null, ?string $endDate = null): array
    {
        $query = Transaction::query()
            ->completed()
            ->betweenDates($startDate, $endDate);

        // Agregasi query keseluruhan (satu query efisien)
        $totals = (clone $query)
            ->selectRaw("
                SUM(CASE WHEN payment_method = 'CASH' THEN 1 ELSE 0 END) AS cash_count,
                COALESCE(SUM(CASE WHEN payment_method = 'CASH' THEN total ELSE 0 END), 0) AS cash_total,
                SUM(CASE WHEN payment_method = 'QRIS' THEN 1 ELSE 0 END) AS qris_count,
                COALESCE(SUM(CASE WHEN payment_method = 'QRIS' THEN total ELSE 0 END), 0) AS qris_total,
                COUNT(id) AS combined_count,
                COALESCE(SUM(total), 0) AS combined_total
            ")
            ->first();

        $cashCount = (int) ($totals->cash_count ?? 0);
        $cashTotal = (float) ($totals->cash_total ?? 0);
        $qrisCount = (int) ($totals->qris_count ?? 0);
        $qrisTotal = (float) ($totals->qris_total ?? 0);
        $combinedCount = (int) ($totals->combined_count ?? 0);
        $combinedTotal = (float) ($totals->combined_total ?? 0);

        $cashPercent = $combinedTotal > 0 ? round(($cashTotal / $combinedTotal) * 100, 1) : 0;
        $qrisPercent = $combinedTotal > 0 ? round(($qrisTotal / $combinedTotal) * 100, 1) : 0;

        // Rincian per hari (§12.3)
        $dailyBreakdown = (clone $query)
            ->selectRaw("
                transaction_date,
                SUM(CASE WHEN payment_method = 'CASH' THEN 1 ELSE 0 END) AS cash_count,
                COALESCE(SUM(CASE WHEN payment_method = 'CASH' THEN total ELSE 0 END), 0) AS cash_total,
                SUM(CASE WHEN payment_method = 'QRIS' THEN 1 ELSE 0 END) AS qris_count,
                COALESCE(SUM(CASE WHEN payment_method = 'QRIS' THEN total ELSE 0 END), 0) AS qris_total,
                COUNT(id) AS combined_count,
                COALESCE(SUM(total), 0) AS combined_total
            ")
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'desc')
            ->get();

        return [
            'cash_count' => $cashCount,
            'cash_total' => $cashTotal,
            'cash_percent' => $cashPercent,
            'qris_count' => $qrisCount,
            'qris_total' => $qrisTotal,
            'qris_percent' => $qrisPercent,
            'combined_count' => $combinedCount,
            'combined_total' => $combinedTotal,
            'daily_breakdown' => $dailyBreakdown,
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
     * Laporan Laba Rugi & Arus Kas (Financial Summary) dengan 3 Catatan Pembayaran (§12)
     */
    public function getFinancialSummaryReport(?string $startDate = null, ?string $endDate = null): array
    {
        // 1. Tiga Catatan Pembayaran POS (Cash, QRIS, Total Gabungan)
        $paymentData = $this->getPaymentMethodReport($startDate, $endDate);

        $posRevenue = $paymentData['combined_total'];
        $posCount = $paymentData['combined_count'];

        // 2. Total Pendapatan Kotor POS (Cash + QRIS)
        $totalGrossIncome = $posRevenue;

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

        // 4. Laba Bersih Operasional = Total Gabungan POS (Cash + QRIS) - Total Pengeluaran (§12.2)
        $netProfit = $totalGrossIncome - $totalExpenses;
        $profitMargin = $totalGrossIncome > 0 ? ($netProfit / $totalGrossIncome) * 100 : 0;

        return [
            'payment_summary' => $paymentData,
            'pos_revenue' => $posRevenue,
            'pos_count' => $posCount,
            'total_gross_income' => $totalGrossIncome,
            'total_expenses' => $totalExpenses,
            'expense_count' => $expenseCount,
            'net_profit' => $netProfit,
            'profit_margin' => round($profitMargin, 1),
            'expenses_by_category' => $expensesByCategory,
            'daily_breakdown' => $paymentData['daily_breakdown'],
        ];
    }
}
