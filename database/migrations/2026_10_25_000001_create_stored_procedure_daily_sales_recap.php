<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // =========================================================================
        // 3. STORED PROCEDURE: Rekapitulasi Ringkasan Penjualan Harian Kasir
        // =========================================================================
        // Nama: sp_get_daily_sales_summary(IN p_date, OUT p_total_revenue, OUT p_total_transactions)
        // Deskripsi: Menghitung total omset dan jumlah struk pada tanggal tertentu
        //            menggunakan parameter input dan output di level database MySQL.
        // =========================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_daily_sales_summary");
        DB::unprepared("
            CREATE PROCEDURE sp_get_daily_sales_summary(
                IN p_date DATE,
                OUT p_total_revenue DECIMAL(14, 2),
                OUT p_total_transactions INT
            )
            BEGIN
                SELECT 
                    COALESCE(SUM(total), 0),
                    COUNT(*)
                INTO 
                    p_total_revenue,
                    p_total_transactions
                FROM transactions
                WHERE status = 'completed'
                  AND DATE(transaction_date) = p_date;
            END
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_daily_sales_summary");
    }
};
