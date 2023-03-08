<?php

namespace App\Grammars\Casts;

use App\Enums\TaskType;
use App\Grammars\DTO\Task\Params\GenerationParams;
use App\Grammars\DTO\Task\Params\ReverseParams;

class TaskParams extends MultiDataCast
{
    protected function getDataClass(array $attributes): ?string
    {
        return match (TaskType::tryFrom($attributes['type'])) {
            TaskType::GENERATE => GenerationParams::class,
            TaskType::REVERSE => ReverseParams::class,
            default => null,
        };
    }
}
