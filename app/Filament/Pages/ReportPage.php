<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Services\ReportService;
use Carbon\Carbon;
use Filament\Pages\Page;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'FINANCE';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $title = 'Laporan Penjualan & Analisis';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.report-page';

    public string $activeTab = 'pos'; // 'pos' or 'catering'
    public string $period = 'this_month'; // today, this_week, this_month, custom, all
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?int $selectedProductId = null;

    public function mount(): void
    {
        $this->activeTab = 'pos';
        $this->period = 'this_month';
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updatedPeriod(string $value): void
    {
        $now = Carbon::now();
        match ($value) {
            'today' => [
                $this->startDate = $now->copy()->format('Y-m-d'),
                $this->endDate = $now->copy()->format('Y-m-d'),
            ],
            'this_week' => [
                $this->startDate = $now->copy()->startOfWeek()->format('Y-m-d'),
                $this->endDate = $now->copy()->endOfWeek()->format('Y-m-d'),
            ],
            'this_month' => [
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d'),
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d'),
            ],
            'all' => [
                $this->startDate = null,
                $this->endDate = null,
            ],
            default => null,
        };
    }

    public function exportCsv(ReportService $reportService): StreamedResponse
    {
        $filename = 'laporan_' . $this->activeTab . '_' . date('Ymd_His') . '.csv';

        if ($this->activeTab === 'pos') {
            $report = $reportService->getSalesReport(
                startDate: $this->startDate,
                endDate: $this->endDate,
                productId: $this->selectedProductId
            );

            $response = new StreamedResponse(function () use ($report) {
                $handle = fopen('php://output', 'w');
                // CSV Header
                fputcsv($handle, ['No. Transaksi', 'Tanggal', 'Waktu', 'Kasir', 'Metode Bayar', 'Total (Rp)', 'Status']);

                foreach ($report['transactions'] as $tx) {
                    fputcsv($handle, [
                        $tx->transaction_number,
                        $tx->transaction_date,
                        $tx->transaction_time,
                        $tx->cashier?->name ?? 'Kasir',
                        $tx->payment_method,
                        $tx->total,
                        $tx->status,
                    ]);
                }
                fclose($handle);
            });
        } else {
            $cateringReport = $reportService->getCateringReport(
                startDate: $this->startDate,
                endDate: $this->endDate
            );

            $response = new StreamedResponse(function () use ($cateringReport) {
                $handle = fopen('php://output', 'w');
                // CSV Header
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
        }

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    public function getViewData(): array
    {
        $reportService = app(ReportService::class);
        $products = Product::orderBy('name')->get();

        if ($this->activeTab === 'pos') {
            $salesData = $reportService->getSalesReport(
                startDate: $this->startDate,
                endDate: $this->endDate,
                productId: $this->selectedProductId
            );

            return [
                'products' => $products,
                'summary' => $salesData['summary'],
                'transactions' => $salesData['transactions'],
                'productSales' => $salesData['product_sales'] ?? collect(),
            ];
        }

        $cateringData = $reportService->getCateringReport(
            startDate: $this->startDate,
            endDate: $this->endDate
        );

        return [
            'products' => $products,
            'summary' => $cateringData['summary'],
            'orders' => $cateringData['orders'],
            'statusBreakdown' => $cateringData['status_breakdown'],
        ];
    }
}
