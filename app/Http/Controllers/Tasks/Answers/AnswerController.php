<?php

namespace App\Http\Controllers\Tasks\Answers;

use App\Actions\SendAnswerAction;
use App\Enums\AssignedTaskAnswerStatus;
use App\Enums\TaskType;
use App\Exceptions\Tasks\Answers\AnswerAlreadySentException;
use App\Http\Validation\Rules\ArrayOfNonEmpty;
use App\Http\Validation\Rules\CharsSet;
use App\Http\Validation\Rules\ContainsOnlyFrom;
use App\Http\Validation\Rules\GrammarRules;
use App\Http\Validation\Rules\NotIncludedCharsFrom;
use App\Infrastructure\Toast;
use App\Models\AssignedTask;
use App\Models\TaskAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class AnswerController
{
    public function show(AssignedTask $assignedTask, TaskAnswer $taskAnswer): Response
    {
        return Inertia::render('Tasks/Answers/Edit', [
            'assignedTask' => $assignedTask->load(['task']),
            'answer' => $taskAnswer->exists ? $taskAnswer : null,
        ]);
    }

    public function remove(AssignedTask $assignedTask, TaskAnswer $taskAnswer): RedirectResponse
    {
        try {
            $taskAnswer->deleteOrFail();
            Toast::success('Решение успешно удалено');
        } catch (Throwable) {
            Toast::error('При удалении решения возникла ошибка');
        }

        return redirect()->route('dashboard');
    }

    public function send(AssignedTask $assignedTask, TaskAnswer $taskAnswer): RedirectResponse
    {
        try {
            app(SendAnswerAction::class)($taskAnswer);
            Toast::success('Решение сдано на проверку');
        } catch (AnswerAlreadySentException) {
            Toast::info('Задание уже было сдано');
        }

        return redirect()->route('dashboard');
    }

    public function save(Request $request, AssignedTask $assignedTask, TaskAnswer $taskAnswer): RedirectResponse
    {
        $data = $request->validate([
            'answer' => ['required', 'array'],
            ...match ($assignedTask->task->type) {
                TaskType::GENERATE => [
                    'answer.input_strings' => ['required', 'array', 'min:1', new ArrayOfNonEmpty()],
//                    'answer.input_strings.*' => ['required', 'string', 'min:1'],
                ],
                TaskType::REVERSE => [
                    'answer.grammar.terms' => ['required', 'string', 'min:1', new CharsSet()],
                    'answer.grammar.non_terms' => ['required', 'string', 'min:1', new CharsSet(), new NotIncludedCharsFrom('answer.grammar.terms')],
                    'answer.grammar.root_term' => ['required', 'string', 'size:1', new ContainsOnlyFrom('answer.grammar.non_terms')],
                    'answer.grammar.rules' => ['required', 'array', new GrammarRules("answer.grammar.terms", 'answer.grammar.non_terms', 'answer.grammar.root_term')],
                ],
            },
        ]);

        if (!$taskAnswer->exists) {
            if (!RateLimiter::remaining("tasks.$assignedTask->id.answers.new", 1)) {
                // TODO: Почему-то пропускает если поставить минуту...
                Toast::error('Создавать новые решения можно не чаще, чем раз в минуту');
                return redirect()->back();
            }

            $taskAnswer->assigned_task_id = $assignedTask->id;
            $taskAnswer->type = $assignedTask->task->type;
            $taskAnswer->status = AssignedTaskAnswerStatus::DRAFT;
        } elseif ($taskAnswer->status !== AssignedTaskAnswerStatus::DRAFT) {
            Toast::error('Нельзя редактировать отправленные на проверку решения');
            return redirect()->back();
        }

        $taskAnswer->fill($data);

        $exists = $taskAnswer->exists;
        try {
            $taskAnswer->saveOrFail();
            Toast::success('Решение успешно сохранено');
            RateLimiter::hit("tasks.$assignedTask->id.answers.new", 60);
        } catch (Throwable $throwable) {
//            Toast::error('При сохранении решения произошла ошибка');
            Toast::error($throwable->getMessage());
        }

        return $exists
            ? redirect()->back()
            : redirect()->route('tasks.answers.edit.show', [$assignedTask->id, $taskAnswer->id]);
    }
}
