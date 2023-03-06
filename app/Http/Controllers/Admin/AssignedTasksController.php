<?php

namespace App\Http\Controllers\Admin;

use App\Models\AssignedTask;
use Inertia\Inertia;
use Inertia\Response;

class AssignedTasksController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Tasks/Assigned/List', [
            'assignedTasks' => AssignedTask::query()
                ->with([/*'answers',*/ 'user', 'task'])
                ->latest()
                ->paginate(),
        ]);
    }
}
