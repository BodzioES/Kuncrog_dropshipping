<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;

Auth::routes(['verify' => true]);

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/products', ProductController::class);

    Route::get('/users/list', [UserController::class, 'index'])->middleware('auth');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
