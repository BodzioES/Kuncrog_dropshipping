<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {//website default
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
