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

        // 1. TRIGGER: Potong stok produk otomatis setelah item transaksi POS dimasukkan
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

        // 2. TRIGGER: Update payment_status katering otomatis setelah pembayaran dicatat
        DB::unprepared("DROP TRIGGER IF EXISTS trg_after_catering_payment_insert");
        DB::unprepared("
            CREATE TRIGGER trg_after_catering_payment_insert
            AFTER INSERT ON catering_payments
            FOR EACH ROW
            BEGIN
                DECLARE v_total_order DECIMAL(14, 2);
                DECLARE v_total_paid DECIMAL(14, 2);

                SELECT total INTO v_total_order 
                FROM catering_orders 
                WHERE id = NEW.catering_order_id;

                SELECT COALESCE(SUM(amount), 0) INTO v_total_paid 
                FROM catering_payments 
                WHERE catering_order_id = NEW.catering_order_id;

                IF v_total_paid >= v_total_order THEN
                    UPDATE catering_orders 
                    SET payment_status = 'PAID'
                    WHERE id = NEW.catering_order_id;
                ELSEIF v_total_paid > 0 THEN
                    UPDATE catering_orders 
                    SET payment_status = 'DP'
                    WHERE id = NEW.catering_order_id;
                ELSE
                    UPDATE catering_orders 
                    SET payment_status = 'UNPAID'
                    WHERE id = NEW.catering_order_id;
                END IF;
            END
        ");

        // 3. STORED FUNCTION: Hitung sisa tagihan katering (Total Order - Total Terbayar)
        DB::unprepared("DROP FUNCTION IF EXISTS fn_get_catering_remaining_balance");
        DB::unprepared("
            CREATE FUNCTION fn_get_catering_remaining_balance(p_order_id BIGINT)
            RETURNS DECIMAL(14, 2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total_order DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_total_paid DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_remaining DECIMAL(14, 2) DEFAULT 0.00;

                SELECT COALESCE(total, 0) INTO v_total_order 
                FROM catering_orders 
                WHERE id = p_order_id;

                SELECT COALESCE(SUM(amount), 0) INTO v_total_paid 
                FROM catering_payments 
                WHERE catering_order_id = p_order_id;

                SET v_remaining = GREATEST(0.00, v_total_order - v_total_paid);
                RETURN v_remaining;
            END
        ");

        // 4. STORED FUNCTION: Hitung Laba Bersih Sederhana pada rentang tanggal
        // Formula: (Total POS + Total Bayar Catering) - Total Pengeluaran
        DB::unprepared("DROP FUNCTION IF EXISTS fn_calculate_simple_profit");
        DB::unprepared("
            CREATE FUNCTION fn_calculate_simple_profit(p_start_date DATE, p_end_date DATE)
            RETURNS DECIMAL(14, 2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_pos_income DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_catering_income DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_expenses DECIMAL(14, 2) DEFAULT 0.00;

                -- Pendapatan POS berstatus completed
                SELECT COALESCE(SUM(total), 0) INTO v_pos_income
                FROM transactions
                WHERE status = 'completed'
                  AND transaction_date BETWEEN p_start_date AND p_end_date;

                -- Penghasilan riil catering (uang masuk dari catering_payments)
                SELECT COALESCE(SUM(amount), 0) INTO v_catering_income
                FROM catering_payments
                WHERE payment_date BETWEEN p_start_date AND p_end_date;

                -- Total pengeluaran yang approved
                SELECT COALESCE(SUM(amount), 0) INTO v_expenses
                FROM expenses
                WHERE status = 'APPROVED'
                  AND expense_date BETWEEN p_start_date AND p_end_date;

                RETURN (v_pos_income + v_catering_income) - v_expenses;
            END
        ");

        // 5. STORED PROCEDURE: Hitung ulang subtotal dan total pesanan katering
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_recalculate_catering_order_totals");
        DB::unprepared("
            CREATE PROCEDURE sp_recalculate_catering_order_totals(IN p_order_id BIGINT)
            BEGIN
                DECLARE v_subtotal DECIMAL(14, 2) DEFAULT 0.00;
                DECLARE v_discount DECIMAL(14, 2) DEFAULT 0.00;

                SELECT COALESCE(SUM(subtotal), 0) INTO v_subtotal
                FROM catering_order_items
                WHERE catering_order_id = p_order_id;

                SELECT COALESCE(discount, 0) INTO v_discount
                FROM catering_orders
                WHERE id = p_order_id;

                UPDATE catering_orders
                SET subtotal = v_subtotal,
                    total = GREATEST(0.00, v_subtotal - v_discount)
                WHERE id = p_order_id;
            END
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared("DROP TRIGGER IF EXISTS trg_after_transaction_item_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_after_catering_payment_insert");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_get_catering_remaining_balance");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_calculate_simple_profit");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_recalculate_catering_order_totals");
    }
};
