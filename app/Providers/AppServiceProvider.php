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
        } catch (\Throwable $e) {
            // Ignore if DB not ready
        }
    }
}
