<?php

namespace App\Grammars\Casts;

use App\Enums\TaskType;
use App\Grammars\DTO\Task\Params\GenerationParams;
use App\Grammars\DTO\Task\Params\ReverseParams;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use JsonException;
use Spatie\LaravelData\Contracts\BaseData;
use Spatie\LaravelData\Exceptions\CannotCastData;
use Spatie\LaravelData\Support\EloquentCasts\DataEloquentCast;

class TaskParams extends DataEloquentCast
{
    public function __construct()
    {
        parent::__construct('');
    }

    /**
     * @throws JsonException
     */
    public function get($model, string $key, $value, array $attributes): ?BaseData
    {
        $this->dataClass = $this->getDataClass($attributes);
        return parent::get($model, $key, $value, $attributes);
    }

    /**
     * @throws CannotCastData
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        $this->dataClass = $this->getDataClass($attributes);
        return parent::set($model, $key, $value, $attributes);
    }

    protected function getDataClass($attributes): ?string
    {
        return match (TaskType::tryFrom($attributes['type'])) {
            TaskType::GENERATE => GenerationParams::class,
            TaskType::REVERSE => ReverseParams::class,
            default => null,
        };
    }
}
