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
                transaction_date AS date,
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

        if (auth()->check() && auth()->user()->email === 'dummy@yansfood.id') {
            $productSalesQuery->where('transactions.cashier_id', auth()->id());
        } elseif (auth()->check()) {
            $dummyId = \App\Models\User::where('email', 'dummy@yansfood.id')->value('id');
            if ($dummyId) {
                $productSalesQuery->where(function ($q) use ($dummyId) {
                    $q->where('transactions.cashier_id', '!=', $dummyId)
                      ->orWhereNull('transactions.cashier_id');
                });
            }
        }

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

        // Tambahkan persentase porsi pada setiap kategori pengeluaran
        $expensesByCategory->transform(function ($item) use ($totalExpenses) {
            $item->percent = $totalExpenses > 0 ? round(($item->total_amount / $totalExpenses) * 100, 1) : 0;
            return $item;
        });

        // 5. Rincian Hasil Uang Bersih Per Bulan
        $revMonthly = Transaction::completed()
            ->selectRaw("
                DATE_FORMAT(transaction_date, '%Y-%m') as m_key,
                COUNT(*) as tx_count,
                COALESCE(SUM(CASE WHEN payment_method = 'CASH' THEN total ELSE 0 END), 0) as cash_rev,
                COALESCE(SUM(CASE WHEN payment_method = 'QRIS' THEN total ELSE 0 END), 0) as qris_rev,
                COALESCE(SUM(total), 0) as total_rev
            ")
            ->groupBy('m_key')
            ->get()
            ->keyBy('m_key');

        $expMonthly = Expense::where('expenses.status', 'APPROVED')
            ->selectRaw("
                DATE_FORMAT(expense_date, '%Y-%m') as m_key,
                COUNT(*) as exp_count,
                COALESCE(SUM(amount), 0) as total_exp
            ")
            ->groupBy('m_key')
            ->get()
            ->keyBy('m_key');

        $allMonthKeys = $revMonthly->keys()->merge($expMonthly->keys())->unique()->sortDesc();

        $monthlyBreakdown = $allMonthKeys->map(function ($key) use ($revMonthly, $expMonthly) {
            $rev = $revMonthly->get($key);
            $exp = $expMonthly->get($key);

            $revenue = (float) ($rev->total_rev ?? 0);
            $cashRev = (float) ($rev->cash_rev ?? 0);
            $qrisRev = (float) ($rev->qris_rev ?? 0);
            $expenses = (float) ($exp->total_exp ?? 0);
            $txCount = (int) ($rev->tx_count ?? 0);
            $expCount = (int) ($exp->exp_count ?? 0);

            $net = $revenue - $expenses;
            $margin = $revenue > 0 ? ($net / $revenue) * 100 : 0;

            try {
                $date = Carbon::createFromFormat('Y-m', $key);
                $label = $date->translatedFormat('F Y');
            } catch (\Throwable $e) {
                $label = $key;
            }

            return (object) [
                'month_key' => $key,
                'month_label' => $label,
                'revenue' => $revenue,
                'cash_revenue' => $cashRev,
                'qris_revenue' => $qrisRev,
                'expenses' => $expenses,
                'net_profit' => $net,
                'profit_margin' => round($margin, 1),
                'tx_count' => $txCount,
                'expense_count' => $expCount,
                'is_surplus' => $net >= 0,
            ];
        });

        // 6. Rincian Hasil Uang Bersih Per Tahun
        $revYearly = Transaction::completed()
            ->selectRaw("
                YEAR(transaction_date) as y_key,
                COUNT(*) as tx_count,
                COALESCE(SUM(CASE WHEN payment_method = 'CASH' THEN total ELSE 0 END), 0) as cash_rev,
                COALESCE(SUM(CASE WHEN payment_method = 'QRIS' THEN total ELSE 0 END), 0) as qris_rev,
                COALESCE(SUM(total), 0) as total_rev
            ")
            ->groupBy('y_key')
            ->get()
            ->keyBy('y_key');

        $expYearly = Expense::where('expenses.status', 'APPROVED')
            ->selectRaw("
                YEAR(expense_date) as y_key,
                COUNT(*) as exp_count,
                COALESCE(SUM(amount), 0) as total_exp
            ")
            ->groupBy('y_key')
            ->get()
            ->keyBy('y_key');

        $allYearKeys = $revYearly->keys()->merge($expYearly->keys())->unique()->sortDesc();

        $yearlyBreakdown = $allYearKeys->map(function ($key) use ($revYearly, $expYearly) {
            $rev = $revYearly->get($key);
            $exp = $expYearly->get($key);

            $revenue = (float) ($rev->total_rev ?? 0);
            $cashRev = (float) ($rev->cash_rev ?? 0);
            $qrisRev = (float) ($rev->qris_rev ?? 0);
            $expenses = (float) ($exp->total_exp ?? 0);
            $txCount = (int) ($rev->tx_count ?? 0);
            $expCount = (int) ($exp->exp_count ?? 0);

            $net = $revenue - $expenses;
            $margin = $revenue > 0 ? ($net / $revenue) * 100 : 0;

            return (object) [
                'year' => (string) $key,
                'revenue' => $revenue,
                'cash_revenue' => $cashRev,
                'qris_revenue' => $qrisRev,
                'expenses' => $expenses,
                'net_profit' => $net,
                'profit_margin' => round($margin, 1),
                'tx_count' => $txCount,
                'expense_count' => $expCount,
                'is_surplus' => $net >= 0,
            ];
        });

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
            'monthly_breakdown' => $monthlyBreakdown,
            'yearly_breakdown' => $yearlyBreakdown,
        ];
    }
}
