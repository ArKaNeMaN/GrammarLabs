<?php

namespace App\Grammars\DTO;

use App\Infrastructure\Set;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Grammar extends Data
{
    public const NULL_TERM = '%';

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

    /**
     * @return Set<string>
     */
    public function getTermsSet(): Set
    {
        return new Set(str_split($this->terms));
    }

    /**
     * @return Set<string>
     */
    public function getNonTermsSet(): Set
    {
        return new Set(str_split($this->non_terms));
    }
}
