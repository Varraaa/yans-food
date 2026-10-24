<?php

use App\Http\Controllers\Admin\AuthController;
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
    $categories = ProductCategory::all();
    $products = Product::with('category')->get();
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
    Route::post('/pos/pay-cash', [PosController::class, 'payCash'])->name('pos.pay-cash');
    Route::post('/pos/qris/prepare', [PosController::class, 'prepareQris'])->name('pos.qris.prepare');
    Route::get('/pos/qris/{token}', [PosController::class, 'showQris'])->name('pos.qris.show');
    Route::post('/pos/qris/{token}/confirm', [PosController::class, 'confirmQris'])->name('pos.qris.confirm');
    Route::post('/pos/qris/{token}/cancel', [PosController::class, 'cancelQris'])->name('pos.qris.cancel');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Transaksi Kasir POS
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // Produk
    Route::resource('products', ProductController::class)->except(['show']);

    // Resep
    Route::resource('recipes', RecipeController::class);


    // Pengeluaran (Full CRUD)
    Route::resource('expenses', ExpenseController::class);

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');
    Route::get('/reports/export/financial', [ReportController::class, 'exportFinancialCsv'])->name('reports.export-financial');
    Route::get('/reports/export/sales', [ReportController::class, 'exportSalesCsv'])->name('reports.export-sales');

    // Printer
    Route::resource('printers', PrinterController::class)->only(['index', 'store', 'update', 'destroy']);

    // Pengguna (Owner Single Admin)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users', [UserController::class, 'update'])->name('users.update');

    // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// Storage fallback for local environment without symlink privileges
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');



