<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TasksListController;
use App\Http\Controllers\Admin\UsersListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Profile\ProfileEditController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class);

Route::middleware('auth')->group(static function () {
    Route::get('dashboard', DashboardController::class)
        ->name('dashboard');

    Route::get('profile/edit', [ProfileEditController::class, 'show'])
        ->name('user.profile.edit.show');
    Route::put('profile/edit', [ProfileEditController::class, 'save'])
        ->name('user.profile.edit.save');

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(static function () {
    Route::get('/', AdminController::class)
        ->name('admin.main');

    Route::prefix('tasks')->group(static function () {
        Route::get('list', [TasksListController::class, 'show'])
            ->name('admin.tasks.list.show');

        Route::delete('{task}', [TasksListController::class, 'removeTask'])
            ->name('admin.tasks.remove');

        Route::get('create', [TaskController::class, 'show'])
            ->name('admin.tasks.create');
        Route::post('create', [TaskController::class, 'save']);

        Route::get('{task}', [TaskController::class, 'show'])
            ->name('admin.tasks.edit');
        Route::put('{task}', [TaskController::class, 'save']);
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
