<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GrammarController;
use App\Http\Controllers\Admin\GrammarsListController;
use App\Http\Controllers\Admin\UsersListController;
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

    Route::prefix('grammars')->group(static function () {
        Route::get('list', [GrammarsListController::class, 'show'])
            ->name('admin.grammars.list.show');

        Route::delete('{grammar}', [AdminController::class, 'removeGrammar'])
            ->name('admin.grammars.remove');

        Route::get('create', [GrammarController::class, 'show'])
            ->name('admin.grammars.create');
        Route::post('create', [GrammarController::class, 'save']);

        Route::get('{grammar}', [GrammarController::class, 'show'])
            ->name('admin.grammars.edit');
        Route::put('{grammar}', [GrammarController::class, 'save']);
    });

    Route::prefix('users')->group(static function () {
        Route::get('list', [UsersListController::class, 'show'])
            ->name('admin.users.list.show');
        Route::get('list/data', UsersListController::class)
            ->name('admin.users.list');
        Route::delete('list/{user}', [UsersListController::class, 'removeUser'])
            ->name('admin.users.list.remove-user');
        Route::put('list/{user}/name', [UsersListController::class, 'changeUserName'])
            ->name('admin.users.list.change-user-name');
        Route::put('list/{user}/pass', [UsersListController::class, 'changeUserPass'])
            ->name('admin.users.list.change-user-pass');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'show'])
        ->name('register');

    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'show'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login']);
});
