<?php

namespace App\Grammars;

use App\Grammars\DTO\Grammar;
use App\Grammars\DTO\GrammarRule;
use App\Grammars\Enums\GrammarType;
use App\Grammars\Exceptions\UnsupportedGrammarTypeException;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class GrammarsRunner
{
    /**
     * @var array<array{left: string, right: string}>
     */
    protected readonly array $rulesList;
    protected readonly GrammarClassifier $grammarClassifier;
    protected readonly GrammarType $grammarType;

    /**
     * @throws UnsupportedGrammarTypeException
     */
    public function __construct(
        protected readonly Grammar $grammar,
    ) {
        $this->grammarClassifier = new GrammarClassifier($this->grammar);
        $this->grammarType = $this->grammarClassifier->classify();

        if (!in_array($this->grammarType, [GrammarType::REGULAR, GrammarType::CONTEXT_FREE], true)) {
            throw new UnsupportedGrammarTypeException();
        }

        $rules = [];
        foreach ($this->grammar->rules as $rule) {
            foreach ($rule->rights as $right) {
                $rules[] = [
                    'left' => $rule->left,
                    'right' => $right,
                ];
            }
        }
        $this->rulesList = $rules;
    }

    public function validate(string $str): bool
    {
//        foreach ($this->rulesList as $rule) {
//            substr_replace();
//        }

        return false;
    }
}
