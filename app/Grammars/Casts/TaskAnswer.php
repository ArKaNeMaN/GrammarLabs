<?php

namespace App\Grammars\Casts;

use App\Enums\TaskType;
use App\Grammars\DTO\Task\Answers\GenerationAnswer;
use App\Grammars\DTO\Task\Answers\ReverseAnswer;

class TaskAnswer extends MultiDataCast
{
    protected function getDataClass(array $attributes): ?string
    {
        return match (TaskType::tryFrom($attributes['type'])) {
            TaskType::GENERATE => GenerationAnswer::class,
            TaskType::REVERSE => ReverseAnswer::class,
            default => null,
        };
    }
}
