<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;

class PrinterSeeder extends Seeder
{
    public function run(): void
    {
        Printer::firstOrCreate(
            ['name' => 'Printer Kasir Utama'],
            [
                'connection_type' => 'usb',
                'paper_width' => '58mm',
                'status' => 'active',
                'settings' => [
                    'auto_cut' => false,
                    'cash_drawer_kick' => true,
                    'print_logo' => true,
                ],
            ]
        );
    }
}
