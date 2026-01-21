<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/categories/{id}', [HomeController::class, 'categoryProducts'])->name('category.products');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('product.show');

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Cart page
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Test images
Route::get('/test-images', function () {
    $products = \App\Models\Product::take(5)->get();
    return view('test-images', compact('products'));
});

// Route publique pour servir les images
Route::get('/images/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($fullPath);
    return response()->file($fullPath, ['Content-Type' => $mimeType]);
})->where('path', '.*')->name('image');