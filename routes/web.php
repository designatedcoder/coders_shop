<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\LaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Search\AlgoliaSearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', WelcomeController::class)->name('welcome');

/**  SHOP */
Route::resource('shop', ShopController::class)->parameter('shop', 'product:slug')->only(['index', 'show']);

/** CART */
Route::resource('cart', CartController::class)->parameter('cart', 'product')->except(['edit', 'create']);
Route::prefix('cart/later')->name('later.')->group(function() {
    Route::post('/later/{product}', [LaterController::class, 'store'])->name('store');
    Route::patch('/later/{product}', [LaterController::class, 'update'])->name('update');
    Route::delete('/later/{product}', [LaterController::class, 'destroy'])->name('destroy');
    Route::post('/move/{product}', [LaterController::class, 'moveToCart'])->name('moveToCart');
});

/** COUPONS  */
Route::resource('coupon', CouponController::class)->parameter('coupon', '')->only(['store', 'destroy']);

/** CHECKOUT */
Route::get('/guest/checkout', [CheckoutController::class, 'index'])->name('guest.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

/** SEARCH */
Route::get('/search-algolia', [AlgoliaSearchController::class, 'index'])->name('searchAlgolia.index');

/**  AUTH USERS */
Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/invoice/{order:confirmation_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::resource('invoice', InvoiceController::class)->parameter('invoice', 'order:confirmation_number')->only(['show', 'store']);
});
