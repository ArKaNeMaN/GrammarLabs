<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GrammarController;
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

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(static function () {
    Route::get('/', AdminController::class)
        ->name('admin.main');

    Route::delete('grammars/{grammar}', [AdminController::class, 'removeGrammar'])
        ->name('admin.grammars.remove');


    Route::get('grammars/create', [GrammarController::class, 'show'])
        ->name('admin.grammars.create');

    Route::post('grammars/create', [GrammarController::class, 'save'])
        ->name('admin.grammars.create');


    Route::get('grammars/{grammar}', [GrammarController::class, 'show'])
        ->name('admin.grammars.edit');

    Route::put('grammars/{grammar}', [GrammarController::class, 'save'])
        ->name('admin.grammars.edit');

});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])
        ->name('register');

    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'show'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login']);
});
