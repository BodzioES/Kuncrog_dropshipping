<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductPageController;
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
Route::post('/checkout/update-total', [CheckoutController::class, 'updateTotal']);


Route::get('/product_page/{product}',[ProductPageController::class,'show'])->name('product_page.show');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['can:isAdmin'])->group(function () {

        Route::get('admin/dashboard', [AdminController::class,'index'])->name('admin.dashboard');

        Route::resource('admin/dashboard/products', ProductController::class);

        Route::get('admin/dashboard/users/list', [UserController::class, 'index'])->name('admin.users.index');
        Route::delete('admin/dashboard/users/list/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('admin/dashboard/orders/list', [OrderController::class, 'index'])->name('admin.orders.index');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

