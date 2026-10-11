<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Pastikan user admin default tersedia
        User::firstOrCreate(
            ['email' => 'admin@yansfood.id'],
            [
                'name' => 'Admin Yan\'s Food',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // User kasir default
        User::firstOrCreate(
            ['email' => 'kasir@yansfood.id'],
            [
                'name' => 'Kasir Utama',
                'password' => Hash::make('password'),
                'role' => 'cashier',
            ]
        );

        // 2. Seed Master Data
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            ExpenseCategorySeeder::class,
            PrinterSeeder::class,
        ]);
    }
}
