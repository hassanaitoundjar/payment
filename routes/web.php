<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// PayPal IPN webhook (must be outside middleware group)
Route::post('ipn/paypal', [CheckoutController::class, 'handlePayPalIPN'])
    ->name('ipn.paypal')
    ->withoutMiddleware(['web']);

Route::middleware([
    'web',
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Admin Routes
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::middleware(['auth'])->group(function () {
                Route::get('/', [AdminController::class, 'index'])->name('dashboard');
                Route::resource('products', ProductController::class);
                Route::resource('orders', OrderController::class)->except(['create', 'store', 'destroy']);
                Route::resource('coupons', CouponController::class);
            });
        });
    });

    // Checkout Routes
    Route::get('checkout/{checkoutLink}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon');
    Route::get('checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/cancel/{orderNumber}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

require __DIR__.'/auth.php';
