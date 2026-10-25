<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = App\Models\Product::all(['id', 'name', 'image']);
echo "Total Products: " . $products->count() . PHP_EOL;

$images = $products->pluck('image');
echo "Unique Images: " . $images->unique()->count() . PHP_EOL;

if ($images->count() === $images->unique()->count()) {
    echo "SUCCESS: Semua produk memiliki foto unik (tidak ada duplikat foto)!" . PHP_EOL;
} else {
    echo "WARNING: Ada duplikat foto!" . PHP_EOL;
}
