<?php

namespace App\Grammars\DTO;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Grammar extends Data
{
    /**
     * @param  string  $non_terms
     * @param  string  $terms
     * @param  string  $root_term
     * @param  DataCollection<int, GrammarRule>  $rules
     */
    public function __construct(
        public string $non_terms,
        public string $terms,
        #[Max(1)]
        public string $root_term,
        #[DataCollectionOf(GrammarRule::class)]
        public DataCollection $rules,
    ) {
    }
}
