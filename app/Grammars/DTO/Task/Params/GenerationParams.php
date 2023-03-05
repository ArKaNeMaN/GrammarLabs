<?php

namespace App\Grammars\DTO\Task\Params;

use App\Grammars\DTO\Grammar;
use Spatie\LaravelData\Data;

class GenerationParams extends Data
{
    public function __construct(
        public Grammar $grammar,
        public int $required_str_count,
    ) {
    }
}
