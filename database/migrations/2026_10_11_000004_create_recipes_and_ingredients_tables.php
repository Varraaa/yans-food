<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('yield')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('ingredient_name');
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 30);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
        Schema::dropIfExists('recipes');
    }
};
