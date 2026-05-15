<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Inventori Toko Wowo
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard (atau login jika belum auth)
Route::get('/', fn () => redirect()->route('dashboard'));

// ── Rute yang memerlukan autentikasi ──────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Produk — CRUD penuh
    Route::resource('products', ProductController::class)
        ->except(['show']);

    // Profil (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Auth routes dari Laravel Breeze ──────────────────────────────────────
require __DIR__.'/auth.php';
