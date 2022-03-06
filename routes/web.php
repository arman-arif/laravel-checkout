<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
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

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/dashboard', 'dash')->middleware(['auth'])->name('dashboard');
});


Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'cart')->name('cart');
    Route::get('buy-now/{product}', 'buyNow')->name('buy-now');
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::delete('/cart/remove', 'remove')->name('cart.remove');
});

// Route::resource('product', ProductController::class);

Route::get('purchase/{product}', [PurchaseController::class, 'purchase'])->name('purchase');


Route::controller(PaymentController::class)->group(function () {
    Route::get('/payment', 'payment')->name('payment');
    Route::post('/payment/confirm', 'confirm')->name('payment.confirm');
    Route::post('/single-payment/{product}', 'singlePayment')->name('single-payment');
});


Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::controller(AjaxController::class)->group(function () {
        Route::get('products', 'getProducts')->name('products');
        Route::get('product/{product}', 'getProduct')->name('product');
    });
});

require __DIR__ . '/auth.php';
