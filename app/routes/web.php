<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('welcome', function () { return view('welcome');})->name('welcome');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
    Route::post('add', [CartController::class, 'add'])->name('cart.add');
    Route::post('update', [CartController::class, 'update'])->name('cart.update');
    Route::post('remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply');
    Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});