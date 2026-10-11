<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 30);
            $table->text('customer_address');
            $table->date('event_date');
            $table->time('event_time');
            $table->string('event_purpose')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('discount', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->enum('status', [
                'PENDING',
                'CONFIRMED',
                'IN_PROGRESS',
                'READY',
                'DELIVERING',
                'COMPLETED',
                'CANCELLED'
            ])->default('PENDING');
            $table->enum('payment_status', [
                'UNPAID',
                'DP',
                'PAID'
            ])->default('UNPAID');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('catering_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catering_order_id')->constrained('catering_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnUpdate()->nullOnDelete();
            $table->string('product_name'); // historical snapshot
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2); // historical snapshot
            $table->decimal('subtotal', 14, 2);
            $table->timestamps();
        });

        Schema::create('catering_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catering_order_id')->constrained('catering_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('payment_number', 50)->unique();
            $table->enum('payment_type', ['CASH', 'DP', 'PELUNASAN']);
            $table->decimal('amount', 14, 2);
            $table->string('payment_method', 50)->default('CASH');
            $table->date('payment_date');
            $table->foreignId('received_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_payments');
        Schema::dropIfExists('catering_order_items');
        Schema::dropIfExists('catering_orders');
    }
};
