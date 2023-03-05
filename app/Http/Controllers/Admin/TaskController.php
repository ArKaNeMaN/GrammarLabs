<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GrammarRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Grammar;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TaskController
{
    public function show(Task $task): Response
    {
        return Inertia::render('Admin/Tasks/TaskEdit', [
            'task' => $task->exists ? $task : null,
        ]);
    }

    public function save(TaskRequest $request, Task $task): RedirectResponse
    {
        $task->fill($request->validated())->save();

        return redirect()->route('admin.tasks.edit', $task);
    }
}
