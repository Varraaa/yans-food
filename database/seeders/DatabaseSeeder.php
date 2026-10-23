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
        // 1. Akun Tunggal: Owner & Admin Utama Yan's Food
        User::firstOrCreate(
            ['email' => 'admin@yansfood.id'],
            [
                'name' => 'Owner / Admin Yan\'s Food',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Hapus akun kasir jika sebelumnya sempat terbuat (karena Yan's Food dikelola 1 orang admin tunggal)
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
