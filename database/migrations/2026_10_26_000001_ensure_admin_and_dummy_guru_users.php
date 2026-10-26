<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'guru@yansfood.id')->delete();
    }
};
