<?php

namespace App\Actions;

use App\Enums\AssignedTaskAnswerStatus;
use App\Exceptions\Tasks\Answers\AnswerAlreadySentException;
use App\Models\TaskAnswer;

class SendAnswerAction
{
    /**
     * @throws AnswerAlreadySentException
     */
    public function __invoke(TaskAnswer $answer): void
    {
        if ($answer->status !== AssignedTaskAnswerStatus::DRAFT) {
            throw new AnswerAlreadySentException();
        }

        $answer->status = AssignedTaskAnswerStatus::SENT;
        $answer->save();

        // TODO: Либо через ивент, либо прям тут запускать джобу валидации грамматикой
    }
}
