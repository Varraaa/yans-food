<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

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

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/pesan-catering', [\App\Http\Controllers\PublicCateringOrderController::class, 'store'])->name('pesan-catering.store');

