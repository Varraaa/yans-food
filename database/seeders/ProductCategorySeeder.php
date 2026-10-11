<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan Ringan',
            'Makanan Berat',
            'Mie Instan',
            'Minuman Segar',
            'Paket Katering',
        ];

        foreach ($categories as $cat) {
            ProductCategory::firstOrCreate(['name' => $cat]);
        }
    }
}
