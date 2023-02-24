<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class);

Route::middleware('auth')->group(static function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
});

Route::middleware(['auth', 'can:admin'])->group(static function () {
    Route::get('admin', AdminController::class)
        ->name('admin.main');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])
        ->name('register');

    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'show'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login']);
});
