<?php

namespace App\Grammars;

use App\Grammars\DTO\Grammar;

class GrammarsValidator
{
    /**
     * @var array<string, string>
     */
    protected readonly array $rulesMap;

    public function __construct(
        protected readonly Grammar $grammar,
    ) {
        foreach ($this->grammar->rules as $rule) {
            foreach ($rule->rights as $right) {
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
