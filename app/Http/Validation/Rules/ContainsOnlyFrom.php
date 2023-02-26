<?php

namespace App\Http\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class ContainsOnlyFrom implements ValidationRule, DataAwareRule
{
    private array $from;

    public function __construct(
        private readonly string $fromKey,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('Значение :attribute должно быть строкой.');
            return;
        }

        foreach (str_split($value) as $char) {
            if (Arr::first($this->from, static fn($fromChar) => $char === $fromChar) === null) {
                $fail("Значение :attribute должно состоять только из символов значения $this->fromKey.");
                return;
            }
        }
    }

    public function setData(array $data): static
    {
        $this->from = str_split($data[$this->fromKey] ?? '');

        return $this;
    }
}
