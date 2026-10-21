<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketPriceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderController;

// 1. Sisi Customer (Publik)
Route::get('/', [OrderController::class, 'index'])->name('customer.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');

// 2. Dashboard Utama Admin (Bawaan Breeze yang diarahkan ke Rekap Pesanan)
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Grup Route Terproteksi (Admin)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Alias Admin Dashboard & Update Status Pesanan
    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Resource CRUD Master Data Bioskop
    Route::resource('/admin/movies', MovieController::class);
    Route::resource('/admin/ticket-prices', TicketPriceController::class);
    Route::resource('/admin/schedules', ScheduleController::class);
});

require __DIR__.'/auth.php';
