<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grammar;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TasksListController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Tasks/TasksList', [
            'tasks' => Task::query()->latest()->get(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function removeTask(Task $grammar): RedirectResponse
    {
        $grammar->deleteOrFail();

        return redirect()->route('admin.tasks.list.show');
    }
}
