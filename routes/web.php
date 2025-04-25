<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('action-login', [LoginController::class, 'actionLogin']);

Route::middleware(['auth'])->group(function (){
    Route::resource('dashboard', DashboardController::class);
    Route::resource('users', UsersController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('product', ProductController::class);
    Route::get('kasir', [ProductController::class, 'getProduct'])->name('kasir');
    
});


