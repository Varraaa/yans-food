<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya jalankan pada MySQL / MariaDB
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // =========================================================================
        // 1. TRIGGER: Potong stok produk otomatis setelah item transaksi POS tersimpan
        // =========================================================================
        // Tabel: transaction_items
        // Event: AFTER INSERT
        // Deskripsi: Setiap kali kasir menyelesaikan transaksi dan detail item menu
        //            masuk ke tabel transaction_items, stok produk pada tabel 'products'
        //            akan otomatis berkurang sesuai kuantitas yang dibeli pembeli.
        // =========================================================================
        DB::unprepared("DROP TRIGGER IF EXISTS trg_after_transaction_item_insert");
        DB::unprepared("
            CREATE TRIGGER trg_after_transaction_item_insert
            AFTER INSERT ON transaction_items
            FOR EACH ROW
            BEGIN
                IF NEW.product_id IS NOT NULL THEN
                    UPDATE products 
                    SET stock = GREATEST(0, stock - NEW.quantity)
                    WHERE id = NEW.product_id;
                END IF;
            END
        ");

        // =========================================================================
        // 2. STORED FUNCTION: Hitung Laba Bersih Sederhana pada rentang tanggal
        // =========================================================================
        // Nama: fn_calculate_simple_profit(p_start_date, p_end_date)
        // Return: DECIMAL(14, 2)
        // Rumus: Total Omset Kasir POS - Total Pengeluaran Dapur
        // Deskripsi: Menghitung laba bersih operasional riil Yan's Food dalam rentang
        //            tanggal tertentu langsung dieksekusi di level database MySQL.
        // =========================================================================
        DB::unprepared("DROP FUNCTION IF EXISTS fn_calculate_simple_profit");
        DB::unprepared("
            CREATE FUNCTION fn_calculate_simple_profit(p_start_date DATE, p_end_date DATE)
            RETURNS DECIMAL(14, 2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_pos_income DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_expenses DECIMAL(14, 2) DEFAULT 0.00;

                -- Pendapatan POS berstatus completed
                SELECT COALESCE(SUM(total), 0) INTO v_pos_income
                FROM transactions
                WHERE status = 'completed'
                  AND transaction_date BETWEEN p_start_date AND p_end_date;

                -- Total pengeluaran yang approved
                SELECT COALESCE(SUM(amount), 0) INTO v_expenses
                FROM expenses
                WHERE status = 'APPROVED'
                  AND expense_date BETWEEN p_start_date AND p_end_date;

                RETURN v_pos_income - v_expenses;
            END
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared("DROP TRIGGER IF EXISTS trg_after_transaction_item_insert");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_calculate_simple_profit");
    }
};
