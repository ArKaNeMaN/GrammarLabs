<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TaskType;
use App\Http\Requests\AssignedTaskRequest;
use App\Infrastructure\Toast;
use App\Models\AssignedTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AssignedTaskController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Tasks/Assigned/Assign', [
            'users' => User::query()->select(['id', 'name', 'group_name'])->get(),
            'tasks' => Task::query()->select(['id', 'name', 'type'])->get(),
        ]);
    }

    public function assign(AssignedTaskRequest $request, Task $task): RedirectResponse
    {
        $data = $request->validated();
        $exists = AssignedTask::query()
            ->where('user_id', $data['user_id'])
            ->where('task_id', $data['task_id'])
            ->exists();

        if ($exists) {
            Toast::error('Этому студенту уже выдано это задание');
            return redirect()->back();
        }

        AssignedTask::query()->create($data);
        Toast::success('Задание успешно назначено');

        if ($request->input('preserve_page', true)) {
            return redirect()->back();
        }

        return redirect()->route('admin.assigned-tasks.list.show');
    }
}
