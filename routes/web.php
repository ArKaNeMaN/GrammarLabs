<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssignedTaskController;
use App\Http\Controllers\Admin\AssignedTasksListController;
use App\Http\Controllers\Admin\TaskAnswerController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TasksListController;
use App\Http\Controllers\Admin\UsersListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Profile\ProfileEditController;
use App\Http\Controllers\Tasks\Answers\AnswerController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class);

Route::middleware('auth')->group(static function () {
    Route::get('dashboard', DashboardController::class)
        ->name('dashboard');

    Route::get('profile/edit', [ProfileEditController::class, 'show'])
        ->name('user.profile.edit.show');
    Route::put('profile/edit', [ProfileEditController::class, 'save'])
        ->name('user.profile.edit.save');

    Route::prefix('task/{assignedTask}')->group(static function () {
        Route::get('answer', [AnswerController::class, 'show'])
            ->name('tasks.answers.new.show');

        Route::post('answer', [AnswerController::class, 'save'])
            ->name('tasks.answers.new');

        // TODO: Добавить проверку на соответствие решения заданию
        Route::get('answer/{taskAnswer}', [AnswerController::class, 'show'])
            ->name('tasks.answers.edit.show');

        Route::put('answer/{taskAnswer}', [AnswerController::class, 'save'])
            ->name('tasks.answers.edit');

        Route::put('answer/{taskAnswer}/send', [AnswerController::class, 'send'])
            ->name('tasks.answers.send');

        Route::delete('answer/{taskAnswer}/remove', [AnswerController::class, 'remove'])
            ->name('tasks.answers.remove');
    });

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(static function () {
    Route::get('/', AdminController::class)
        ->name('admin.main');

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

    Route::prefix('assigned-tasks')->group(static function () {
        Route::get('list', [AssignedTasksListController::class, 'show'])
            ->name('admin.assigned-tasks.list.show');
        Route::delete('list/cancel-task/{assignedTask}', [AssignedTasksListController::class, 'cancel'])
            ->name('admin.assigned-tasks.list.cancel-task');

        Route::get('assign', [AssignedTaskController::class, 'show'])
            ->name('admin.assigned-tasks.assign.show');

        Route::post('assign', [AssignedTaskController::class, 'assign']);
    });

    Route::prefix('answers/{taskAnswer}')->group(static function () {
        Route::get('/', [TaskAnswerController::class, 'show'])
            ->name('admin.answers.show');

        Route::put('/accept', [TaskAnswerController::class, 'accept'])
            ->name('admin.answers.accept');

        Route::put('/reject', [TaskAnswerController::class, 'reject'])
            ->name('admin.answers.reject');
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
