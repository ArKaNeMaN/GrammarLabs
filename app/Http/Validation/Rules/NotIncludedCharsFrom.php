<?php

namespace App\Http\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class NotIncludedCharsFrom implements ValidationRule, DataAwareRule
{
    private array $from = [];

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

        $val = str_split($value ?? '');

        foreach ($val as $char) {
            if (Arr::first($this->from, static fn($fromChar) => $char === $fromChar) !== null) {
                $fail("Символы в значении :attribute не должны пересекаться с символами значения $this->fromKey.");
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
