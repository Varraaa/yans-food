<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number', 50)->unique();
            $table->date('expense_date');
            $table->enum('expense_type', ['ONE_TIME', 'RECURRING'])->default('ONE_TIME');
            $table->foreignId('category_id')->constrained('expense_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->decimal('amount', 14, 2);
            $table->string('payment_method', 50)->default('CASH');
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_image')->nullable();
            $table->string('status', 30)->default('APPROVED');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
