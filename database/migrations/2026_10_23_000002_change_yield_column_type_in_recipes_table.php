<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('recipes')) {
            try {
                DB::statement("ALTER TABLE recipes MODIFY COLUMN yield VARCHAR(100) NULL DEFAULT '1 Porsi'");
            } catch (\Throwable $e) {
                // Fallback
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('recipes')) {
            try {
                DB::statement("ALTER TABLE recipes MODIFY COLUMN yield INT NULL DEFAULT 1");
            } catch (\Throwable $e) {
                // Fallback
            }
        }
    }
};
