<?php

namespace App\Grammars\DTO\Task\Params;

use Spatie\LaravelData\Data;

class ReverseParams extends Data
{
    /**
     * @param  string[]  $input_strings
     */
    public function __construct(
        public array $input_strings,
//        public array $fail_strings,
    ) {
    }
}
