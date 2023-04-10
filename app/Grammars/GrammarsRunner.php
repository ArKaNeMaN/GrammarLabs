<?php

namespace App\Grammars;

use App\Grammars\DTO\Grammar;
use App\Grammars\Enums\GrammarType;
use App\Grammars\Exceptions\UnsupportedGrammarTypeException;

class GrammarsRunner
{
    /**
     * @var array<string, string>
     */
    protected readonly array $rulesMap;
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

        foreach ($this->grammar->rules as $rule) {
            foreach ($rule->rights as $right) {
                // TODO: А не наоборот ли?) (лень сейчас думать, надо потом не забыть)
                $this->rulesMap[$right] = $rule->left;
            }
        }
    }

    public function validate(string $str): bool
    {
        // TODO: ...

        return false;
    }
}
