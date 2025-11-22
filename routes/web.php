<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductCatalogController;

Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD - HANYA BISA DIAKSES SETELAH LOGIN
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PROFILE ROUTES - HANYA UNTUK USER YANG LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Category Routes
Route::resource('categories', \App\Http\Controllers\CategoryController::class)->middleware('auth');

// Product Routes
Route::resource('products', \App\Http\Controllers\ProductController::class)->middleware('auth');

// Katalog Produk route
Route::get('/product-catalog', [ProductCatalogController::class, 'index'])
    ->middleware(['auth'])
    ->name('product-catalog.index');