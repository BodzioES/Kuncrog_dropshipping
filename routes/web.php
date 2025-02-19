<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {//website default
    return view('welcome');
});

Auth::routes();

Route::get('/users/list', [UserController::class, 'index'])->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home');
