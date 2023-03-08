<?php

namespace App\Grammars\Casts;

use JsonException;
use Spatie\LaravelData\Contracts\BaseData;
use Spatie\LaravelData\Exceptions\CannotCastData;
use Spatie\LaravelData\Support\EloquentCasts\DataEloquentCast;

abstract class MultiDataCast extends DataEloquentCast
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

    abstract protected function getDataClass(array $attributes): ?string;
}
