<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('transactions') && !\Illuminate\Support\Facades\Schema::hasColumn('transactions', 'customer_name')) {
                \Illuminate\Support\Facades\Schema::table('transactions', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('customer_name', 100)->nullable()->after('cashier_id');
                });
            }

            // Hapus kategori pengeluaran Maintenance dan Transportasi
            if (\Illuminate\Support\Facades\Schema::hasTable('expense_categories')) {
                \App\Models\ExpenseCategory::whereIn('name', ['Maintenance', 'Transportasi', 'maintenance', 'transportasi'])
                    ->whereDoesntHave('expenses')
                    ->delete();
            }

            // Pastikan resep tersedia untuk seluruh produk kuliner Yan's Food
            if (\Illuminate\Support\Facades\Schema::hasTable('recipes') && \Illuminate\Support\Facades\Schema::hasTable('products')) {
                try {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE recipes MODIFY COLUMN yield VARCHAR(100) NULL DEFAULT '1 Porsi'");
                } catch (\Throwable $e) {
                    // Ignore if already changed or not supported
                }

                $hasProducts = \App\Models\Product::exists();
                $recipesCount = \App\Models\Recipe::count();
                if ($hasProducts && $recipesCount === 0) {
                    (new \Database\Seeders\RecipeSeeder())->run();
                }
            }
        } catch (\Throwable $e) {
            // Ignore if DB not ready
        }
    }
}
