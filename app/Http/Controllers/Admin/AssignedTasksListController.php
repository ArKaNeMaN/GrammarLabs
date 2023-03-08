<?php

namespace App\Http\Controllers\Admin;

use App\Infrastructure\Toast;
use App\Models\AssignedTask;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class AssignedTasksListController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Tasks/Assigned/List', [
            'assignedTasks' => AssignedTask::query()
                ->with(['user', 'task'])
                ->latest()
                ->paginate(),
        ]);
    }

    public function cancel(AssignedTask $assignedTask): RedirectResponse
    {
        try {
            $assignedTask->deleteOrFail();
            Toast::success('Задание отменено успешно');
        } catch (Throwable) {
            Toast::error('При отмене задания произошла ошибка');
        }

        return redirect()->back();
    }
}
