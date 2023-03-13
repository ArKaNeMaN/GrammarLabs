<?php

namespace App\Grammars\DTO\Task\Answers;

use App\Grammars\DTO\Grammar;
use Spatie\LaravelData\Data;

class ReverseAnswer extends Data
{
    /**
     * @param  string[]  $input_strings
     */
    public function __construct(
        public Grammar $grammar,
    ) {
    }
}
