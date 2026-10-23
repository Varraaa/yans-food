<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions', 'customer_name')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('customer_name', 100)->nullable()->after('cashier_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'customer_name')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('customer_name');
            });
        }
    }
};
