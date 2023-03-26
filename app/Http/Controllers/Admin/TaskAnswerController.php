<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Tasks\Answers\AnswerAlreadyChecked;
use App\Exceptions\Tasks\Answers\AnswerNotSent;
use App\Infrastructure\Toast;
use App\Models\TaskAnswer;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TaskAnswerController
{
    public function show(TaskAnswer $taskAnswer): Response
    {
        $taskAnswer->load(['assignedTask' => static fn($q) => $q->with(['task', 'user'])]);

        return Inertia::render('Admin/Tasks/Assigned/Answers/Show', [
            'answer' => $taskAnswer,
        ]);
    }

    public function accept(TaskAnswer $taskAnswer): RedirectResponse
    {
        try {
            $taskAnswer->accept();
            Toast::success('Решение успешно зачтено');
        } catch (AnswerNotSent|AnswerAlreadyChecked $e) {
            Toast::error($e->getMessage());
        } catch (Throwable) {
            Toast::error('При зачтении решения произошла ошибка');
        }

        return redirect()->route('admin.main');
    }

    public function reject(TaskAnswer $taskAnswer): RedirectResponse
    {
        try {
            $taskAnswer->reject();
            Toast::success('Решение успешно отклонено');
        } catch (AnswerNotSent|AnswerAlreadyChecked $e) {
            Toast::error($e->getMessage());
        } catch (Throwable) {
            Toast::error('При отклонении решения произошла ошибка');
        }

        return redirect()->route('admin.main');
    }
}
