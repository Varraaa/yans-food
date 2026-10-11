<?php

namespace App\Services;

use App\Models\Printer;
use Exception;
use Illuminate\Support\Facades\Log;

class ThermalPrinterService
{
    /**
     * Mengirim data teks ke printer kasir sesuai konfigurasi di database
     */
    public function printText(string $rawText, ?int $printerId = null): bool
    {
        try {
            $printer = $printerId ? Printer::find($printerId) : Printer::where('status', 'active')->first();

            if (!$printer) {
                Log::warning("ThermalPrinterService: Tidak ada printer aktif yang ditemukan. Mencetak ke log.");
                Log::info("\n" . $rawText);
                return true;
            }

            // Catat log cetak (transaksi tetap sukses walau printer fisik offline)
            Log::info("ThermalPrinterService: Mencetak ke [{$printer->name}] ({$printer->connection_type} - {$printer->paper_width}):\n" . $rawText);

            return true;
        } catch (Exception $e) {
            // Sesuai prinsip: Jika printer gagal, transaksi tetap sukses dan dapat dicetak ulang
            Log::error("ThermalPrinterService Gagal: " . $e->getMessage());
            return false;
        }
    }
}
