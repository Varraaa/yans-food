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
        $cateringData = [];

        if ($activeTab === 'financial') {
            $financialData = $reportService->getFinancialSummaryReport($startDate, $endDate);
        } elseif ($activeTab === 'pos') {
            $salesData = $reportService->getSalesReport($startDate, $endDate, $productId ? (int)$productId : null);
        } else {
            $cateringData = $reportService->getCateringReport($startDate, $endDate);
        }

        return view('admin.reports.index', compact(
            'activeTab',
            'period',
            'startDate',
            'endDate',
            'productId',
            'products',
            'financialData',
            'salesData',
            'cateringData'
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
        } elseif ($activeTab === 'catering') {
            $cateringReport = $reportService->getCateringReport($startDate, $endDate);

            $response = new StreamedResponse(function () use ($cateringReport) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['No. Order', 'Nama Pemesan', 'No. WhatsApp', 'Tanggal Acara', 'Total Pesanan (Rp)', 'Status Progres', 'Status Pembayaran']);

                foreach ($cateringReport['orders'] as $order) {
                    fputcsv($handle, [
                        $order->order_number,
                        $order->customer_name,
                        $order->customer_phone,
                        $order->event_date,
                        $order->total,
                        $order->status,
                        $order->payment_status,
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
                fputcsv($handle, ['Uang Masuk Catering', $finReport['catering_income'], "{$finReport['catering_payment_count']} Pembayaran"]);
                fputcsv($handle, ['TOTAL PENDAPATAN KOTOR', $finReport['total_gross_income'], 'Akumulasi Kas Masuk']);
                fputcsv($handle, ['Total Biaya/Pengeluaran Dapur', $finReport['total_expenses'], "{$finReport['expense_count']} Catatan Approved"]);
                fputcsv($handle, ['LABA BERSIH OPERASIONAL', $finReport['net_profit'], "Margin: {$finReport['profit_margin']}%"]);
                fputcsv($handle, []);
                fputcsv($handle, ['RINCIAN BIAYA PER KATEGORI']);
                fputcsv($handle, ['Kategori Biaya', 'Total (Rp)', 'Jumlah']);

                foreach ($finReport['expenses_by_category'] as $cat) {
                    fputcsv($handle, [$cat->category, $cat->total_amount, $cat->count]);
                }
                fclose($handle);
            });
        }

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
