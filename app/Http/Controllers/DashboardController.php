<?php

namespace App\Http\Controllers;

use App\Models\AssignedTask;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $assignedTasks = $user->assignedTasks()->with([
            'task' => static fn($q) => $q->select(['id', 'type', 'name']),
            'lastAnswer' => static fn($q) => $q->select(['status']),
            'answers' => static fn($q) => $q
                ->select(['id', 'assigned_task_id', 'updated_at', 'status'])
                ->with([
                    'assignedTask' => static fn($q) => $q
                        ->select(['task_id', 'id'])
                        ->without(['user'])
                        ->with(['task' => static fn($q) => $q->select(['id', 'name'])]),
                ]),
        ])->get();
        // Жесть страшное))

        $answers = $assignedTasks
            ->reduce(static fn(Collection $acc, AssignedTask $assignedTask) => $acc
                ->push(...$assignedTask->answers), new Collection());

        return Inertia::render('Dashboard', [
            'assignedTasks' => $assignedTasks,
            'answers' => $answers,
        ]);
    }
}
