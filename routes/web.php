<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ZoneController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/zone-registration', [ZoneController::class, 'store'])->name('zone.store');

