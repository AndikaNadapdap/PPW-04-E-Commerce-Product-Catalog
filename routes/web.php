<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Routes untuk Products (Catalog & Detail)
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// API Routes untuk Products
Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/api/products/filter-price', [ProductController::class, 'filterByPrice'])->name('products.filter-price');
Route::get('/api/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/api/categories', [ProductController::class, 'categories'])->name('products.categories');

// Routes untuk Cart Management
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('products.cart');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Routes untuk Checkout Process
Route::get('/checkout', [CheckoutController::class, 'index'])->name('products.checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
Route::get('/order-success', [CheckoutController::class, 'success'])->name('checkout.success');

// API Routes untuk Checkout
Route::get('/api/checkout/totals', [CheckoutController::class, 'getTotals'])->name('checkout.totals');
Route::post('/api/checkout/validate', [CheckoutController::class, 'validateForm'])->name('checkout.validate');
