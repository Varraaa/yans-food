<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CateringIncomeController;
use App\Http\Controllers\Admin\CateringOrderController;
use App\Http\Controllers\Admin\CateringPaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\PrinterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicCateringOrderController;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/menu', function () {
    try {
        $categories = ProductCategory::all();
        $products = Product::with('category')->get();
    } catch (\Throwable $e) {
        $categories = collect();
        $products = collect();
    }
    return view('pages.menu', compact('categories', 'products'));
})->name('menu');

Route::get('/pesan', function () {
    try {
        $products = Product::where('status', 'available')->get();
    } catch (\Throwable $e) {
        $products = collect();
    }
    return view('pages.pesan', compact('products'));
})->name('pesan');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/pesan-catering', [PublicCateringOrderController::class, 'store'])->name('pesan-catering.store');
Route::get('/pesan/katering/{order_number}/sukses', [PublicCateringOrderController::class, 'success'])->name('pesan.katering.sukses');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (Blade + Flowbite Manual Panel)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // POS Kasir
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Transaksi Kasir POS
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // Produk
    Route::resource('products', ProductController::class)->except(['show']);

    // Resep
    Route::resource('recipes', RecipeController::class);

    // Catering
    Route::prefix('catering')->name('catering.')->group(function () {
        // Orders
        Route::get('/orders', [CateringOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CateringOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [CateringOrderController::class, 'updateStatus'])->name('orders.status');

        // Payments
        Route::get('/payments', [CateringPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [CateringPaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [CateringPaymentController::class, 'store'])->name('payments.store');

        // Income
        Route::get('/income', [CateringIncomeController::class, 'index'])->name('income.index');
        Route::get('/income/export', [CateringIncomeController::class, 'exportCsv'])->name('income.export');
    });

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');

    // Printer
    Route::resource('printers', PrinterController::class)->only(['index', 'store', 'update', 'destroy']);

    // Pengguna (Owner Single Admin)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users', [UserController::class, 'update'])->name('users.update');

    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
