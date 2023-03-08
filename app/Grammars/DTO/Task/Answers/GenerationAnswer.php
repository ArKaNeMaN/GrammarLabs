<?php

namespace App\Grammars\DTO\Task\Answers;

use App\Grammars\DTO\Grammar;
use Spatie\LaravelData\Data;

class GenerationAnswer extends Data
{
    public function __construct(
        public Grammar $grammar,
    ) {
    }
}
