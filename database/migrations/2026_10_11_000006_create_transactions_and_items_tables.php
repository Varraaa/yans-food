<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 50)->unique();
            $table->date('transaction_date');
            $table->time('transaction_time');
            $table->foreignId('cashier_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('subtotal', 14, 2);
            $table->decimal('discount', 14, 2)->default(0);
            $table->decimal('total', 14, 2);
            $table->enum('payment_method', ['CASH', 'TRANSFER', 'QRIS'])->default('CASH');
            $table->decimal('amount_paid', 14, 2);
            $table->decimal('change', 14, 2)->default(0);
            $table->enum('status', ['completed', 'cancelled'])->default('completed');
            $table->timestamps();
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnUpdate()->nullOnDelete();
            $table->string('product_name'); // historical snapshot
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2); // historical snapshot
            $table->decimal('subtotal', 14, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
    }
};
