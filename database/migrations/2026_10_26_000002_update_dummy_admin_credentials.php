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
        // Buat atau perbarui akun dummy admin baru
        User::updateOrCreate(
            ['email' => 'dummy@yansfood.id'],
            [
                'name' => 'Admin Dummy',
                'password' => Hash::make('dummy123'),
                'role' => 'admin',
            ]
        );

        // Hapus akun guru lama jika ada
        User::where('email', 'guru@yansfood.id')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'dummy@yansfood.id')->delete();
    }
};
