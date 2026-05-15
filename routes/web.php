<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Setting;
use App\Models\DeliveryArea;
use App\Models\Review;
use App\Models\Feature;
use App\Models\Step;
use App\Models\Faq;

Route::get('/', function () {
    $settings = Setting::pluck('value', 'key');
    $areas = DeliveryArea::all();
    $reviews = Review::latest()->get();
    $features = Feature::all();
    $steps = Step::orderBy('order')->get();
    $faqs = Faq::orderBy('order')->get();
    
    return view('welcome', compact('settings', 'areas', 'reviews', 'features', 'steps', 'faqs'));
});

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/zone-registration', [ZoneController::class, 'store'])->name('zone.store');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.delete');
        Route::post('/orders/clear', [AdminOrderController::class, 'clear'])->name('admin.orders.clear');
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');

        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/features', [SettingController::class, 'features'])->name('admin.features');
        Route::post('/features', [SettingController::class, 'storeFeature'])->name('admin.features.store');
        Route::delete('/features/{feature}', [SettingController::class, 'deleteFeature'])->name('admin.features.delete');
        Route::get('/areas', [SettingController::class, 'areas'])->name('admin.areas');
        Route::post('/areas', [SettingController::class, 'storeArea'])->name('admin.areas.store');
        Route::delete('/areas/{area}', [SettingController::class, 'deleteArea'])->name('admin.areas.delete');
        Route::get('/steps', [SettingController::class, 'steps'])->name('admin.steps');
        Route::post('/steps', [SettingController::class, 'storeStep'])->name('admin.steps.store');
        Route::delete('/steps/{step}', [SettingController::class, 'deleteStep'])->name('admin.steps.delete');
        Route::get('/reviews', [SettingController::class, 'reviews'])->name('admin.reviews');
        Route::post('/reviews', [SettingController::class, 'storeReview'])->name('admin.reviews.store');
        Route::delete('/reviews/{review}', [SettingController::class, 'deleteReview'])->name('admin.reviews.delete');
        Route::get('/pixels', [SettingController::class, 'pixels'])->name('admin.pixels');

        // FAQ routes
        Route::get('/faqs', [SettingController::class, 'faqs'])->name('admin.faqs');
        Route::post('/faqs', [SettingController::class, 'storeFaq'])->name('admin.faqs.store');
        Route::delete('/faqs/{faq}', [SettingController::class, 'deleteFaq'])->name('admin.faqs.delete');
    });
});
