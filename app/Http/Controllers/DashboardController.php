<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return Inertia::render('Dashboard', [
            'assignedTasks' => $user->assignedTasks()->with([
                'task' => static fn($q) => $q->select(['id', 'type', 'name']),
                'lastAnswer' => static fn($q) => $q->select(['status']),
            ])->get(),
        ]);
    }
}
