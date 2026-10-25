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
                $startOfWeek = $now->copy()->startOfWeek();
                $endOfWeek = $now->copy()->endOfWeek();
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();

                // Standar ISO-8601: Mulai Senin jam 00:00 s/d Minggu 23:59:59
                // Reset batas awal bulan: Jika terjadi perubahan bulan (awal bulan), awal bulan adalah awal minggu laporan baru
                $weekStart = $startOfWeek->isSameMonth($now) ? $startOfWeek : $startOfMonth;
                $weekEnd = $endOfWeek->isSameMonth($now) ? $endOfWeek : $endOfMonth;

                $startDate = $weekStart->format('Y-m-d');
                $endDate = $weekEnd->format('Y-m-d');
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
        $type = $request->query('type', $request->query('tab', 'financial'));

        if ($type === 'pos' || $type === 'sales') {
            return $this->exportSalesCsv($request, $reportService);
        }

        return $this->exportFinancialCsv($request, $reportService);
    }

    /**
     * Export CSV Laporan Laba Rugi & Arus Kas (Terpisah & Terstruktur)
     */
    public function exportFinancialCsv(Request $request, ReportService $reportService): StreamedResponse
    {
        [$startDate, $endDate, $period, $periodLabel] = $this->resolveDateRange($request);

        $finReport = $reportService->getFinancialSummaryReport($startDate, $endDate);
        $paySummary = $finReport['payment_summary'] ?? [];

        $filename = 'laporan_laba_rugi_dan_arus_kas_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($finReport, $paySummary, $periodLabel) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM agar terbaca sempurna di Microsoft Excel / Google Sheets
            fwrite($handle, "\xEF\xBB\xBF");

            // HEADER LAPORAN KEUANGAN
            fputcsv($handle, ['LAPORAN KEUANGAN: LABA RUGI & ARUS KAS DAPUR - YAN\'S FOOD']);
            fputcsv($handle, ['Periode Laporan:', $periodLabel]);
            fputcsv($handle, ['Waktu Ekspor:', Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB']);
            fputcsv($handle, ['Mata Uang:', 'Indonesian Rupiah (IDR)']);
            fputcsv($handle, []);

            // BAGIAN 1: RINGKASAN EKSEKUTIF LABA RUGI OPERASIONAL
            fputcsv($handle, ['=== BAGIAN 1: RINGKASAN EKSEKUTIF LABA RUGI OPERASIONAL ===']);
            fputcsv($handle, ['Indikator Keuangan', 'Nilai Bersih (Rp)', 'Keterangan Analisis']);
            fputcsv($handle, [
                'Total Kas Masuk (Omset POS Kasir)',
                $finReport['total_gross_income'],
                'Penerimaan kotor riil kasir dari seluruh pembayaran tunai (Cash) dan QRIS'
            ]);
            fputcsv($handle, [
                'Total Pengeluaran Dapur (Approved)',
                $finReport['total_expenses'],
                "Total belanja bahan baku, gas, kemasan & operasional ({$finReport['expense_count']} catatan disetujui)"
            ]);
            fputcsv($handle, [
                'LABA BERSIH OPERASIONAL (Surplus/Defisit)',
                $finReport['net_profit'],
                'Selisih Kas Masuk dikurangi Seluruh Pengeluaran Dapur'
            ]);
            fputcsv($handle, [
                'Persentase Margin Keuntungan Bersih',
                $finReport['profit_margin'] . '%',
                'Rasio efisiensi laba bersih terhadap omset kasir'
            ]);
            fputcsv($handle, [
                'Status Kondisi Keuangan',
                $finReport['net_profit'] >= 0 ? 'SURPLUS (MENGUNTUNGKAN)' : 'DEFISIT (KURANG DANA)',
                $finReport['net_profit'] >= 0 ? 'Usaha mencetak laba bersih surplus' : 'Pengeluaran dapur melebihi omset penjualan kasir'
            ]);
            fputcsv($handle, []);

            // BAGIAN 2: ARUS KAS MASUK BERDASARKAN METODE PEMBAYARAN
            fputcsv($handle, ['=== BAGIAN 2: ARUS KAS MASUK BERDASARKAN METODE PEMBAYARAN KASIR ===']);
            fputcsv($handle, ['Metode Pembayaran', 'Jumlah Transaksi', 'Porsi Transaksi (%)', 'Total Penerimaan (Rp)', 'Porsi Nominal (%)']);
            fputcsv($handle, [
                'Pembayaran Tunai (CASH)',
                $paySummary['cash_count'] ?? 0,
                ($paySummary['cash_percent'] ?? 0) . '%',
                $paySummary['cash_total'] ?? 0,
                ($paySummary['cash_percent'] ?? 0) . '%'
            ]);
            fputcsv($handle, [
                'Pembayaran Non-Tunai (QRIS)',
                $paySummary['qris_count'] ?? 0,
                ($paySummary['qris_percent'] ?? 0) . '%',
                $paySummary['qris_total'] ?? 0,
                ($paySummary['qris_percent'] ?? 0) . '%'
            ]);
            fputcsv($handle, [
                'TOTAL KAS MASUK GABUNGAN POS',
                $paySummary['combined_count'] ?? 0,
                '100%',
                $paySummary['combined_total'] ?? 0,
                '100%'
            ]);
            fputcsv($handle, []);

            // BAGIAN 3: RINCIAN PENGELUARAN & BIAYA DAPUR PER KATEGORI
            fputcsv($handle, ['=== BAGIAN 3: RINCIAN PENGELUARAN & BIAYA DAPUR PER KATEGORI ===']);
            fputcsv($handle, ['No', 'Kategori Pengeluaran', 'Jumlah Catatan Belanja', 'Total Biaya (Rp)', 'Porsi Dari Total Pengeluaran (%)']);
            $noCat = 1;
            foreach ($finReport['expenses_by_category'] as $cat) {
                fputcsv($handle, [
                    $noCat++,
                    $cat->category_name ?? 'Operasional',
                    $cat->count,
                    $cat->total_amount,
                    $cat->percent . '%'
                ]);
            }
            fputcsv($handle, [
                '',
                'TOTAL PENGELUARAN DAPUR',
                $finReport['expense_count'],
                $finReport['total_expenses'],
                '100%'
            ]);
            fputcsv($handle, []);

            // BAGIAN 4: RINCIAN ARUS KAS HARIAN
            fputcsv($handle, ['=== BAGIAN 4: RINCIAN ARUS KAS HARIAN (CASH FLOW DAILY) ===']);
            fputcsv($handle, ['Tanggal', 'Hari', 'Trx Cash', 'Total Cash (Rp)', 'Trx QRIS', 'Total QRIS (Rp)', 'Total Transaksi', 'Total Kas Masuk Harian (Rp)']);
            foreach ($finReport['daily_breakdown'] as $day) {
                $rawDate = $day->transaction_date instanceof \DateTimeInterface ? $day->transaction_date->format('Y-m-d') : $day->transaction_date;
                try {
                    $dayCarbon = Carbon::parse($rawDate);
                    $dateStr = $dayCarbon->translatedFormat('d-m-Y');
                    $dayName = $dayCarbon->translatedFormat('l');
                } catch (\Throwable $e) {
                    $dateStr = $rawDate;
                    $dayName = '-';
                }

                fputcsv($handle, [
                    $dateStr,
                    $dayName,
                    $day->cash_count,
                    $day->cash_total,
                    $day->qris_count,
                    $day->qris_total,
                    $day->combined_count,
                    $day->combined_total,
                ]);
            }
            fputcsv($handle, []);

            // BAGIAN 5: REKAPITULASI HASIL BERSIH BULANAN (TREN LABA RUGI)
            fputcsv($handle, ['=== BAGIAN 5: REKAPITULASI HASIL BERSIH BULANAN (TREN LABA RUGI) ===']);
            fputcsv($handle, ['Bulan', 'Transaksi Kasir', 'Omset Kasir (Rp)', 'Catatan Biaya', 'Pengeluaran Dapur (Rp)', 'Laba Bersih (Rp)', 'Margin (%)', 'Status Keuangan']);
            foreach ($finReport['monthly_breakdown'] as $m) {
                fputcsv($handle, [
                    $m->month_label,
                    $m->tx_count,
                    $m->revenue,
                    $m->expense_count,
                    $m->expenses,
                    $m->net_profit,
                    $m->profit_margin . '%',
                    $m->is_surplus ? 'SURPLUS' : 'DEFISIT'
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }

    /**
     * Export CSV Laporan Penjualan Kasir POS (Terpisah & Terstruktur)
     */
    public function exportSalesCsv(Request $request, ReportService $reportService): StreamedResponse
    {
        [$startDate, $endDate, $period, $periodLabel] = $this->resolveDateRange($request);
        $productId = $request->query('product_id');

        $productFilterName = 'Semua Menu';
        if ($productId) {
            $selectedProd = Product::find($productId);
            if ($selectedProd) {
                $productFilterName = $selectedProd->name;
            }
        }

        $report = $reportService->getSalesReport($startDate, $endDate, $productId ? (int)$productId : null);
        $totalQtySold = (int) $report['product_sales']->sum('total_quantity');

        $filename = 'laporan_penjualan_kasir_pos_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($report, $periodLabel, $productFilterName, $totalQtySold) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM
            fwrite($handle, "\xEF\xBB\xBF");

            // HEADER LAPORAN PENJUALAN KASIR
            fputcsv($handle, ['LAPORAN PENJUALAN KASIR POS - YAN\'S FOOD']);
            fputcsv($handle, ['Periode Laporan:', $periodLabel]);
            fputcsv($handle, ['Filter Menu:', $productFilterName]);
            fputcsv($handle, ['Waktu Ekspor:', Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB']);
            fputcsv($handle, ['Mata Uang:', 'Indonesian Rupiah (IDR)']);
            fputcsv($handle, []);

            // BAGIAN 1: RINGKASAN PENJUALAN KASIR (SALES SUMMARY)
            fputcsv($handle, ['=== BAGIAN 1: RINGKASAN PENJUALAN KASIR ===']);
            fputcsv($handle, ['Indikator Penjualan', 'Nilai', 'Keterangan']);
            fputcsv($handle, [
                'Total Omset Penjualan (Rp)',
                $report['summary']['total_revenue'],
                'Total penerimaan kotor dari seluruh transaksi selesai'
            ]);
            fputcsv($handle, [
                'Total Transaksi Selesai',
                $report['summary']['transaction_count'],
                'Total struk transaksi berhasil yang tercatat di kasir'
            ]);
            fputcsv($handle, [
                'Rata-rata Nilai per Transaksi (Rp)',
                round($report['summary']['average_transaction']),
                'Rata-rata pengeluaran belanja pelanggan per transaksi'
            ]);
            fputcsv($handle, [
                'Total Porsi Menu Terjual',
                $totalQtySold,
                'Total kuantitas seluruh makanan dan minuman yang laku'
            ]);
            fputcsv($handle, []);

            // BAGIAN 2: PERFORMA PENJUALAN MENU (REKAP PRODUK TERLARIS)
            fputcsv($handle, ['=== BAGIAN 2: PERFORMA PENJUALAN MENU (REKAP PRODUK TERLARIS) ===']);
            fputcsv($handle, ['No', 'Nama Menu Produk', 'Kuantitas Terjual (Porsi)', 'Frekuensi Transaksi', 'Total Omset Menu (Rp)', 'Kontribusi Dari Total Omset (%)']);
            $noProd = 1;
            $totalRev = $report['summary']['total_revenue'] > 0 ? $report['summary']['total_revenue'] : 1;

            foreach ($report['product_sales'] as $prod) {
                $pct = round(($prod->total_sales / $totalRev) * 100, 1);
                fputcsv($handle, [
                    $noProd++,
                    $prod->product_name,
                    $prod->total_quantity,
                    $prod->transaction_count,
                    $prod->total_sales,
                    $pct . '%'
                ]);
            }
            fputcsv($handle, [
                '',
                'TOTAL KESELURUHAN',
                $totalQtySold,
                $report['summary']['transaction_count'],
                $report['summary']['total_revenue'],
                '100%'
            ]);
            fputcsv($handle, []);

            // BAGIAN 3: DAFTAR RINCIAN TRANSAKSI PENJUALAN KASIR
            fputcsv($handle, ['=== BAGIAN 3: DAFTAR RINCIAN TRANSAKSI PENJUALAN KASIR ===']);
            fputcsv($handle, ['No', 'No. Transaksi', 'Tanggal', 'Waktu', 'Nama Pelanggan', 'Kasir', 'Metode Bayar', 'Rincian Menu Yang Dibeli', 'Subtotal (Rp)', 'Diskon (Rp)', 'Total Akhir (Rp)', 'Status']);

            $noTx = 1;
            foreach ($report['transactions'] as $tx) {
                $methodStr = $tx->payment_method instanceof \App\Enums\PaymentMethod ? $tx->payment_method->value : (string) $tx->payment_method;
                $dateStr = $tx->transaction_date instanceof \DateTimeInterface ? $tx->transaction_date->format('d-m-Y') : Carbon::parse($tx->transaction_date)->format('d-m-Y');

                // Rangkai item menu yang dibeli agar admin langsung paham isi transaksi
                $itemsDetail = $tx->items->map(function ($it) {
                    return $it->quantity . 'x ' . $it->product_name;
                })->implode('; ');

                fputcsv($handle, [
                    $noTx++,
                    $tx->transaction_number,
                    $dateStr,
                    substr($tx->transaction_time, 0, 5) . ' WIB',
                    $tx->customer_name ?: '-',
                    $tx->cashier?->name ?? 'Kasir',
                    strtoupper($methodStr),
                    $itemsDetail ?: 'Pesanan Menu',
                    $tx->subtotal,
                    $tx->discount,
                    $tx->total,
                    'Selesai'
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }

    /**
     * Helper untuk menentukan rentang tanggal & label periode bahasa Indonesia
     */
    private function resolveDateRange(Request $request): array
    {
        $period = $request->query('period', 'this_month');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = $now->copy()->format('Y-m-d');
                $endDate = $now->copy()->format('Y-m-d');
                $periodLabel = 'Hari Ini (' . $now->translatedFormat('d F Y') . ')';
                break;
            case 'this_week':
                $startOfWeek = $now->copy()->startOfWeek();
                $endOfWeek = $now->copy()->endOfWeek();
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();

                // Standar ISO-8601: Mulai Senin jam 00:00 s/d Minggu 23:59:59
                // Reset batas awal bulan: Jika terjadi perubahan bulan (awal bulan), awal bulan adalah awal minggu laporan baru
                $weekStart = $startOfWeek->isSameMonth($now) ? $startOfWeek : $startOfMonth;
                $weekEnd = $endOfWeek->isSameMonth($now) ? $endOfWeek : $endOfMonth;

                $startDate = $weekStart->format('Y-m-d');
                $endDate = $weekEnd->format('Y-m-d');
                $periodLabel = 'Minggu Ini (' . $weekStart->translatedFormat('d M') . ' - ' . $weekEnd->translatedFormat('d M Y') . ')';
                break;
            case 'this_month':
                $startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                $periodLabel = 'Bulan Ini (' . $now->translatedFormat('F Y') . ')';
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $endDate = $now->copy()->endOfYear()->format('Y-m-d');
                $periodLabel = 'Tahun Ini (' . $now->format('Y') . ')';
                break;
            case 'custom':
                $startFmt = $startDate ? Carbon::parse($startDate)->translatedFormat('d M Y') : '-';
                $endFmt = $endDate ? Carbon::parse($endDate)->translatedFormat('d M Y') : '-';
                $periodLabel = "Kustom ({$startFmt} s/d {$endFmt})";
                break;
            case 'all':
            default:
                $startDate = null;
                $endDate = null;
                $periodLabel = 'Semua Waktu';
                break;
        }

        return [$startDate, $endDate, $period, $periodLabel];
    }
}
