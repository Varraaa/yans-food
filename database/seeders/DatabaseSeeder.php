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

        // 2. Akun Dummy Admin untuk Guru / Penguji
        User::updateOrCreate(
            ['email' => 'dummy@yansfood.id'],
            [
                'name' => 'Admin Dummy',
                'password' => Hash::make('dummy123'),
                'role' => 'admin',
            ]
        );
        User::where('email', 'guru@yansfood.id')->delete();

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
