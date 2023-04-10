<?php

namespace App\Grammars;

use App\Grammars\DTO\Grammar;
use App\Grammars\Enums\GrammarType;
use App\Infrastructure\Set;

class GrammarClassifier
{
    /**
     * @var Set<string>
     */
    private readonly Set $termsSet;

    /**
     * @var Set<string>
     */
    private readonly Set $nonTermsSet;

    private array $lefts = [];
    private array $rights = [];

    public function __construct(
        private readonly Grammar $grammar,
    ) {
        $this->termsSet = $this->grammar->getTermsSet();
        $this->nonTermsSet = $this->grammar->getNonTermsSet();

        foreach ($grammar->rules as $rule) {
            $this->lefts[] = $rule->left;
            array_push($this->rights, ...$rule->rights);
        }
    }

    private function isRegular(): bool
    {
        if ($this->isLeftBiggerThan(1)) {
            return false;
        }

        $prevDir = null;
        foreach ($this->rights as $right) {
            if (mb_strlen($right) < 2) {
                continue;
            }

            $prevIsTerm = null;
            $changed = false;
            $dir = null;
            for ($i = 0, $ii = mb_strlen($right); $i < $ii; $i++) {
                $isTerm = $this->isTerm($right[$i]);

                if ($dir === null) {
                    $dir = $isTerm;
                }

                if ($prevIsTerm === null) {
                    $prevIsTerm = $isTerm;
                    continue;
                }

                if ($isTerm === $prevIsTerm) {
                    continue;
                }

                if ($changed) {
                    // Если тут переход от одного типа символов к другому
                    // и ранее уже был такой переход, то это не регулярная грамматика
                    return false;
                }

                $changed = true;
                $prevIsTerm = $isTerm;
            }

            if ($prevDir === null) {
                $prevDir = $dir;
                continue;
            }

            if ($prevDir !== $dir) {
                // В правых частях разные направленности
                // Регулярные грамматики такого не допускают
                return false;
            }
        }

        return true;
    }

    private function isContextFree(): bool
    {
        if ($this->isLeftBiggerThan(1)) {
            return false;
        }

        foreach ($this->rights as $right) {
            if (mb_strlen($right) < 2) {
                continue;
            }

            $prevIsTerm = null;
            $changes = 0;
            for ($i = 0, $ii = mb_strlen($right); $i < $ii; $i++) {
                $isTerm = $this->isTerm($right[$i]);

                if ($prevIsTerm === null) {
                    $prevIsTerm = $isTerm;
                    continue;
                }

                if ($isTerm === $prevIsTerm) {
                    continue;
                }

                if ($changes >= 2) {
                    // Если тут переход от одного типа символов к другому
                    // и ранее уже было 2 таких перехода, то это не КС грамматика
                    return false;
                }

                $changes++;
                $prevIsTerm = $isTerm;
            }
        }

        return true;
    }

    private function isContextSensitive(): bool
    {
        // TODO: ...
        // А надо ли оно вообще?)
        return true;
    }

    private function isLeftBiggerThan(int $than): bool
    {
        foreach ($this->lefts as $left) {
            if (mb_strlen($left) > $than) {
                return true;
            }
        }
        return false;
    }

    private function isTerm(string $char): bool
    {
        return $this->termsSet->contains($char);
    }

    public function classify(): GrammarType
    {
        if ($this->isRegular()) {
            return GrammarType::REGULAR;
        }

        if ($this->isContextFree()) {
            return GrammarType::CONTEXT_FREE;
        }

        if ($this->isContextSensitive()) {
            return GrammarType::CONTEXT_SENSITIVE;
        }

        return GrammarType::UNRESTRICTED;
    }
}
