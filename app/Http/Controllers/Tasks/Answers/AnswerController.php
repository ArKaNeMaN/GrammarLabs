<?php

namespace App\Http\Controllers\Tasks\Answers;

use App\Enums\AssignedTaskAnswerStatus;
use App\Enums\TaskType;
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

    // TODO: Добавить удаление решения
    // TODO: Добавить сдачу решения

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
                default => [],
            },
        ]);

        if (!$taskAnswer->exists) {
            $taskAnswer->assigned_task_id = $assignedTask->id;
            $taskAnswer->type = $assignedTask->task->type;
            $taskAnswer->status = AssignedTaskAnswerStatus::DRAFT;
        }

        $taskAnswer->fill($data);

        $exists = $taskAnswer->exists;
        try {
            $taskAnswer->saveOrFail();
            Toast::success('Решение успешно сохранено');
        } catch (Throwable $throwable) {
//            Toast::error('При сохранении решения произошла ошибка');
            Toast::error($throwable->getMessage());
        }

        return $exists
            ? redirect()->back()
            : redirect()->route('tasks.answers.edit.show', [$assignedTask->id, $taskAnswer->id]);
    }
}
