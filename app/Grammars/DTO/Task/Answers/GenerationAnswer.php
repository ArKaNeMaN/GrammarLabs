<?php

namespace App\Grammars\DTO\Task\Answers;

use Spatie\LaravelData\Data;

class GenerationAnswer extends Data
{
    public function __construct(
        public array $input_strings,
    ) {
    }
}
