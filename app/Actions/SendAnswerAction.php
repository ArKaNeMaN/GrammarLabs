<?php

namespace App\Actions;

use App\Enums\AnswerStatus;
use App\Exceptions\Tasks\Answers\AnswerAlreadySentException;
use App\Models\TaskAnswer;

class SendAnswerAction
{
    /**
     * @throws AnswerAlreadySentException
     */
    public function __invoke(TaskAnswer $answer): void
    {
        if ($answer->status !== AnswerStatus::DRAFT) {
            throw new AnswerAlreadySentException();
        }

        $answer->status = AnswerStatus::SENT;
        $answer->save();

        // TODO: Либо через ивент, либо прям тут запускать джобу валидации грамматикой
    }
}
