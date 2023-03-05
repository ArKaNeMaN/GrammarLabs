<?php

namespace App\Grammars\DTO;

use Spatie\LaravelData\Data;

class GrammarRule extends Data
{
    /**
     * @param  string  $left
     * @param  string[]  $rights
     */
    public function __construct(
        public string $left,
        public array $rights,
    ) {
    }

}
