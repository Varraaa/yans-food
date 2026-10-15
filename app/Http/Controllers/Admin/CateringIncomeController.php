<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CateringIncomeController extends Controller
{
    public function index(Request $request, ReportService $reportService)
    {
        $period = $request->query('period', 'this_month');
        $paymentType = $request->query('payment_type', 'all');
        $paymentMethod = $request->query('payment_method', 'all');

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

        $incomeData = $reportService->getCateringIncomeReport(
            startDate: $startDate,
            endDate: $endDate,
            paymentType: $paymentType,
            paymentMethod: $paymentMethod
        );

        $summary = $incomeData['summary'];
        $payments = $incomeData['payments'];

        return view('admin.catering.income.index', compact(
            'summary',
            'payments',
            'period',
            'paymentType',
            'paymentMethod',
            'startDate',
            'endDate'
        ));
    }

    public function exportCsv(Request $request, ReportService $reportService): StreamedResponse
    {
        $period = $request->query('period', 'this_month');
        $paymentType = $request->query('payment_type', 'all');
        $paymentMethod = $request->query('payment_method', 'all');
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

        $incomeData = $reportService->getCateringIncomeReport(
            startDate: $startDate,
            endDate: $endDate,
            paymentType: $paymentType,
            paymentMethod: $paymentMethod
        );

        $filename = 'penghasilan_catering_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($incomeData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No. Kwitansi', 'Tgl. Pembayaran', 'No. Order', 'Nama Pelanggan', 'WhatsApp', 'Jenis Pembayaran', 'Metode Bayar', 'Nominal Masuk (Rp)', 'Catatan']);

            foreach ($incomeData['payments'] as $payment) {
                fputcsv($handle, [
                    $payment->payment_number,
                    $payment->payment_date,
                    $payment->order?->order_number ?? '-',
                    $payment->order?->customer_name ?? '-',
                    $payment->order?->customer_phone ?? '-',
                    $payment->payment_type,
                    $payment->payment_method,
                    $payment->amount,
                    $payment->notes ?? '-',
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
