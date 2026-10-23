<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Bahan Baku',
            'Gas',
            'Listrik',
            'Air',
            'Kemasan',
            'Peralatan',
            'Lain-lain',
        ];

        foreach ($categories as $cat) {
            ExpenseCategory::firstOrCreate(['name' => $cat]);
        }
    }
}
