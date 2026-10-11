<?php

namespace App\Filament\Pages;

use App\Models\CateringPayment;
use App\Services\ReportService;
use Carbon\Carbon;
use Filament\Pages\Page;

class CateringIncomePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'CATERING';

    protected static ?string $navigationLabel = 'Penghasilan Catering';

    protected static ?string $title = 'Rekap Penghasilan Catering';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.catering-income-page';

    public string $period = 'this_month'; // today, this_week, this_month, custom, all
    public ?string $startDate = null;
    public ?string $endDate = null;

    public function mount(): void
    {
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

    public function getViewData(): array
    {
        $reportService = app(ReportService::class);
        $incomeData = $reportService->getCateringIncomeReport($this->startDate, $this->endDate);

        return [
            'summary' => $incomeData['summary'],
            'payments' => $incomeData['payments'],
        ];
    }
}
