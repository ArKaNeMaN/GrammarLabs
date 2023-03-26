<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnswerStatus;
use App\Models\TaskAnswer;
use Inertia\Inertia;
use Inertia\Response;

class AdminController
{
    public function __invoke(): Response
    {
        $answers = TaskAnswer::query()
            ->whereIn('status', [AnswerStatus::SENT, AnswerStatus::ACCEPTED])
            ->with([
                'assignedTask' => static fn($q) => $q
                    ->with([
                        'task' => static fn($q) => $q->select(['name', 'type', 'id']),
                        'user' => static fn($q) => $q->select(['name', 'group_name', 'id']),
                    ])
                    ->select(['id', 'task_id', 'user_id', 'status', 'auto_test_result']),
            ])
            ->select(['status', 'assigned_task_id', 'updated_at', 'id'])
            ->get()
            ->groupBy(static fn(TaskAnswer $answer) => $answer->status->value);

        return Inertia::render('Admin/Main', [
            'sentAnswers' => $answers[AnswerStatus::SENT->value] ?? [],
            'acceptedAnswers' => $answers[AnswerStatus::ACCEPTED->value] ?? [],
        ]);
    }
}
