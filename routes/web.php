<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;

Auth::routes(['verify' => true]);

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/cart/list', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/modal', [CartController::class, 'getCartModalContent']);
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity']);
Route::get('/cart/count', [CartController::class, 'updateCount']);


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['can:isAdmin'])->group(function () {
        Route::resource('products', ProductController::class);

        Route::get('/users/list', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

