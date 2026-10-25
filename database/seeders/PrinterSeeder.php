<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;

class PrinterSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan RPP02N (DT-58B) tercatat dan aktif
        Printer::updateOrCreate(
            ['name' => 'RPP02N (DT-58B)'],
            [
                'connection_type' => 'BLUETOOTH',
                'paper_width' => '58mm',
                'status' => 'ACTIVE',
                'settings' => [
                    'device_name' => 'RPP02N',
                    'model' => 'DT-58B',
                    'interface' => 'USB+BT4.0',
                    'output' => '5V-1A',
                    'char_per_line' => 32,
                    'feed_lines' => 4,
                    'auto_cut' => false,
                ],
            ]
        );
    }
}
