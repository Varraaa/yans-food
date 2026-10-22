<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Bersihkan data lama dengan metode TRANSFER menjadi CASH (bila ada)
        DB::table('transactions')
            ->where('payment_method', 'TRANSFER')
            ->update(['payment_method' => 'CASH']);

        // 2. Tambah kolom paid_at & index laporan
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('change');
            }
        });

        // 3. Ubah enum payment_method menjadi hanya 'CASH' dan 'QRIS'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_method ENUM('CASH', 'QRIS') NOT NULL DEFAULT 'CASH'");
            
            // Isi paid_at untuk data lama yang belum terisi
            DB::statement("UPDATE transactions SET paid_at = STR_TO_DATE(CONCAT(transaction_date, ' ', transaction_time), '%Y-%m-%d %H:%i:%s') WHERE paid_at IS NULL");
        } else {
            // Untuk SQLite (lingkungan testing)
            DB::statement("UPDATE transactions SET paid_at = datetime(transaction_date || ' ' || transaction_time) WHERE paid_at IS NULL");
        }

        // 4. Tambah index majemuk untuk performa query laporan
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['status', 'transaction_date', 'payment_method'], 'idx_transactions_report');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_report');
            $table->dropColumn('paid_at');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_method ENUM('CASH', 'TRANSFER', 'QRIS') NOT NULL DEFAULT 'CASH'");
        }
    }
};
