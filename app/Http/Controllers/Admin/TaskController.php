<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GrammarRequest;
use App\Http\Requests\TaskRequest;
use App\Infrastructure\Toast;
use App\Models\Grammar;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TaskController
{
    public function show(Task $task): Response
    {
        return Inertia::render('Admin/Tasks/TaskEdit', [
            'task' => $task->exists ? $task : null,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function save(TaskRequest $request, Task $task): RedirectResponse
    {
        try {
            $task->fill($request->validated())->saveOrFail();
            Toast::success('Задание успешно сохранено');
        } catch (Throwable) {
            Toast::error('При сохранении задания произошла ошибка');
        }

        return redirect()->route('admin.tasks.edit', $task);
    }
}
