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
        $lowStockCount = Product::where('stock', '<=', 5)->count();

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

        // 2. Total Pendapatan Kas Masuk
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

        // 4. Laba Bersih Operasional
        $netProfit = $totalGrossIncome - $totalExpenses;
        $profitMargin = $totalGrossIncome > 0 ? ($netProfit / $totalGrossIncome) * 100 : 0;

        return [
            'pos_revenue' => $posRevenue,
            'pos_count' => $posCount,
            'total_gross_income' => $totalGrossIncome,
            'total_expenses' => $totalExpenses,
            'expense_count' => $expenseCount,
            'net_profit' => $netProfit,
            'profit_margin' => round($profitMargin, 1),
            'expenses_by_category' => $expensesByCategory,
        ];
    }
}
