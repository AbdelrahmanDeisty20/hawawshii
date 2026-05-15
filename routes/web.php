<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/zone-registration', [ZoneController::class, 'store'])->name('zone.store');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::post('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.update');
        Route::delete('/orders/{order}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');
        Route::post('/orders/clear', [AdminController::class, 'clearOrders'])->name('admin.orders.clear');
        Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('admin.orders.export');
    });
});
