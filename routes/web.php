<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\UserOrdersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

Route::get('/my-ip', function () {
    $ip = request()->ip();

    // pobranie lokalizacji z darmowego API ipapi.co
    $location = null;
    try {
        $response = Http::get("https://ipapi.co/{$ip}/json/");
        if ($response->ok()) {
            $location = $response->json();
        }
    } catch (\Exception $e) {
        $location = ['error' => $e->getMessage()];
    }

    return response()->json([
        'laravel_ip'   => $ip,
        'real_ip'      => $_SERVER['HTTP_X_REAL_IP'] ?? null,
        'forwarded_for'=> $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
        'remote_addr'  => $_SERVER['REMOTE_ADDR'] ?? null,
        'location'     => $location,
    ]);
});

Route::get('/product_page/{product}',[ProductPageController::class,'show'])->name('product_page.show');

Route::get('/my-orders', [UserOrdersController::class, 'index'])->name('myOrders.index');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['can:isAdmin'])->group(function () {

        Route::get('admin/dashboard', [AdminController::class,'index'])->name('admin.dashboard');

        Route::resource('admin/dashboard/products', ProductController::class);

        Route::get('admin/dashboard/users/list', [UserController::class, 'index'])->name('admin.users.index');
        Route::delete('admin/dashboard/users/list/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('admin/dashboard/orders/list', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('admin/dashboard/orders/list/show/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::get('admin/dashboard/orders/list/edit/{order}', [OrderController::class, 'edit'])->name('admin.orders.edit');
        Route::put('admin/dashboard/orders/list/edit/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('admin/dashboard/orders/list/edit/{order}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');

    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

