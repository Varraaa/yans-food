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
        // 1. Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@yansfood.id'],
            [
                'name' => 'Owner / Admin Yan\'s Food',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Dummy Khusus Guru / Penguji
        User::updateOrCreate(
            ['email' => 'guru@yansfood.id'],
            [
                'name' => 'Guru / Penguji (Demo Admin)',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Hapus akun kasir lama jika ada
        User::where('email', 'kasir@yansfood.id')->delete();

        // 2. Seed Master Data
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            RecipeSeeder::class,
            ExpenseCategorySeeder::class,
            PrinterSeeder::class,
        ]);
    }
}
