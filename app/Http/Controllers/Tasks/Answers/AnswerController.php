<?php

namespace App\Http\Controllers\Tasks\Answers;

use App\Models\AssignedTask;
use App\Models\TaskAnswer;
use Inertia\Inertia;
use Inertia\Response;

class AnswerController
{
    public function show(AssignedTask $assignedTask, TaskAnswer $taskAnswer): Response
    {
        return Inertia::render('Tasks/Answers/Edit', [
            'assignedTask' => $assignedTask->load(['task']),
            'answer' => $taskAnswer->exists ? $taskAnswer : null,
        ]);
    }
}
