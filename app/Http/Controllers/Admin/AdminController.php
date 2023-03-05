<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grammar;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class AdminController
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Main');
    }

    /**
     * @throws Throwable
     */
    public function removeTask(Task $task): RedirectResponse
    {
        $task->deleteOrFail();

        return redirect()->route('admin.main');
    }
}
