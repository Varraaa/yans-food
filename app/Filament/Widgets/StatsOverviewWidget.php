<?php

namespace App\Filament\Widgets;

use App\Services\ReportService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $reportService = app(ReportService::class);
        $kpis = $reportService->getDashboardKpis();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($kpis['revenue_today'], 0, ',', '.'))
                ->description('Total penjualan POS hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Transaksi Hari Ini', $kpis['transactions_today'] . ' struk')
                ->description('Jumlah transaksi POS')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('info'),

            Stat::make('Pengeluaran Hari Ini', 'Rp ' . number_format($kpis['expenses_today'], 0, ',', '.'))
                ->description('Operasional kasir & dapur')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Laba Bersih Sederhana', 'Rp ' . number_format($kpis['simple_net_profit_today'], 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($kpis['simple_net_profit_today'] >= 0 ? 'success' : 'danger'),

            Stat::make('Catering Belum Lunas', $kpis['catering_unpaid_count'] . ' pesanan')
                ->description('Status UNPAID / DP')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Catering Selesai', $kpis['catering_completed_count'] . ' acara')
                ->description('Status order COMPLETED')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),
        ];
    }
}
