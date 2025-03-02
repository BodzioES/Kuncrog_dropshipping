<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {//website default
    return view('welcome');
});

Auth::routes();

Route::get('/users/list', [UserController::class, 'index'])->middleware('auth');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth');

Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::Post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::get('/products/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');


Route::get('/home', [HomeController::class, 'index'])->name('home');

