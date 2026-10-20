<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request, ReportService $reportService)
    {
        $activeTab = $request->query('tab', 'financial');
        $period = $request->query('period', 'this_month');
        $productId = $request->query('product_id');

        $startDate = null;
        $endDate = null;
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = $now->copy()->format('Y-m-d');
                $endDate = $now->copy()->format('Y-m-d');
                break;
            case 'this_week':
                $startDate = $now->copy()->startOfWeek()->format('Y-m-d');
                $endDate = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $endDate = $now->copy()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                $startDate = $request->query('start_date');
                $endDate = $request->query('end_date');
                break;
            case 'all':
            default:
                $startDate = null;
                $endDate = null;
                break;
        }

        $products = Product::orderBy('name')->get();

        $financialData = [];
        $salesData = [];

        if ($activeTab === 'financial') {
            $financialData = $reportService->getFinancialSummaryReport($startDate, $endDate);
        } else {
            $salesData = $reportService->getSalesReport($startDate, $endDate, $productId ? (int)$productId : null);
        }

        return view('admin.reports.index', compact(
            'activeTab',
            'period',
            'startDate',
            'endDate',
            'productId',
            'products',
            'financialData',
            'salesData'
        ));
    }

    public function exportCsv(Request $request, ReportService $reportService): StreamedResponse
    {
        $activeTab = $request->query('tab', 'financial');
        $period = $request->query('period', 'this_month');
        $productId = $request->query('product_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($period !== 'custom' && $period !== 'all') {
            $now = Carbon::now();
            match ($period) {
                'today' => [$startDate = $now->copy()->format('Y-m-d'), $endDate = $now->copy()->format('Y-m-d')],
                'this_week' => [$startDate = $now->copy()->startOfWeek()->format('Y-m-d'), $endDate = $now->copy()->endOfWeek()->format('Y-m-d')],
                'this_month' => [$startDate = $now->copy()->startOfMonth()->format('Y-m-d'), $endDate = $now->copy()->endOfMonth()->format('Y-m-d')],
                'this_year' => [$startDate = $now->copy()->startOfYear()->format('Y-m-d'), $endDate = $now->copy()->endOfYear()->format('Y-m-d')],
                default => null,
            };
        }

        $filename = 'laporan_' . $activeTab . '_' . date('Ymd_His') . '.csv';

        if ($activeTab === 'pos') {
            $report = $reportService->getSalesReport($startDate, $endDate, $productId ? (int)$productId : null);

            $response = new StreamedResponse(function () use ($report) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['No. Transaksi', 'Tanggal', 'Waktu', 'Kasir', 'Metode Bayar', 'Subtotal (Rp)', 'Diskon (Rp)', 'Total (Rp)', 'Status']);

                foreach ($report['transactions'] as $tx) {
                    fputcsv($handle, [
                        $tx->transaction_number,
                        $tx->transaction_date,
                        $tx->transaction_time,
                        $tx->cashier?->name ?? 'Kasir',
                        $tx->payment_method,
                        $tx->subtotal,
                        $tx->discount,
                        $tx->total,
                        $tx->status,
                    ]);
                }
                fclose($handle);
            });
        } else {
            $finReport = $reportService->getFinancialSummaryReport($startDate, $endDate);

            $response = new StreamedResponse(function () use ($finReport) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['KOMPONEN LAPORAN', 'NILAI (RP)', 'KETERANGAN']);
                fputcsv($handle, ['Pendapatan Kasir POS', $finReport['pos_revenue'], "{$finReport['pos_count']} Transaksi"]);
                fputcsv($handle, ['TOTAL PENDAPATAN KOTOR', $finReport['total_gross_income'], 'Akumulasi Kasir POS']);
                fputcsv($handle, ['Total Biaya/Pengeluaran Dapur', $finReport['total_expenses'], "{$finReport['expense_count']} Catatan Approved"]);
                fputcsv($handle, ['LABA BERSIH OPERASIONAL', $finReport['net_profit'], "Margin: {$finReport['profit_margin']}%"]);
                fputcsv($handle, []);
                fputcsv($handle, ['RINCIAN BIAYA PER KATEGORI']);
                fputcsv($handle, ['Kategori Biaya', 'Total (Rp)', 'Jumlah']);

                foreach ($finReport['expenses_by_category'] as $cat) {
                    fputcsv($handle, [$cat->category_name ?? 'Operasional', $cat->total_amount, $cat->count]);
                }
                fclose($handle);
            });
        }

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
