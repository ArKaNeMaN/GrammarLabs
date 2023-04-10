<?php

namespace App\Http\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class GrammarRules implements ValidationRule, DataAwareRule
{

    private array $terms = [];
    private array $nonTerms = [];
    private string $rootTerm = '';

    public function __construct(
        private readonly string $termsKey,
        private readonly string $nonTermsKey,
        private readonly string $rootTermKey,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value) || !array_is_list($value)) {
            $fail('Значение :attribute должно быть списком.');
            return;
        }

        $charsMap = [];
        foreach ($this->terms as $term) {
            $charsMap[$term] = 'term';
        }
        foreach ($this->nonTerms as $nonTerm) {
            $charsMap[$nonTerm] = 'nonTerm';
        }

        $hasRuleForRoot = false;
        $lefts = [];
        foreach ($value as $rule) {
            if (empty($rule['left'] ?? null) || empty($rule['rights'] ?? null)) {
                $fail('Элементы массива :attribute должны содержать непустые поля left и rights.');
                return;
            }

            if (!is_string($rule['left'])) {
                $fail('Поля left элементов массива :attribute должны быть строками.');
                return;
            }

            if (!is_array($rule['rights']) || !array_is_list($rule['rights'])) {
                $fail('Поля rights элементов массива :attribute должны быть списками.');
                return;
            }

            if ($lefts[$rule['left']] ?? false) {
                $fail('Значения полей left элементов массива :attribute должны быть уникальны.');
                return;
            }
            $lefts[$rule['left']] = true;

            $hasNonTerm = false;
            foreach (str_split($rule['left']) as $char) { // счётчик по строке быстрее
                $charType = $charsMap[$char] ?? null;
                if (empty($charType)) {
                    $fail("Поля left элементов массива :attribute должны содержать только символы из значений $this->termsKey и $this->nonTermsKey.");
                    return;
                }

                if ($charType === 'nonTerm') {
                    $hasNonTerm = true;
                }
            }

            if (!$hasNonTerm) {
                $fail("В значении :attribute должно присутствовать правило для $this->rootTermKey.");
                return;
            }

            if ($rule['left'] === $this->rootTerm) {
                $hasRuleForRoot = true;
            }

            foreach ($rule['rights'] as $right) {
                if (!is_string($right)) {
                    $fail("Элементы массива rights элементов массива :attribute должны являться строками.");
                    return;
                }

                if ($right !== '-') {
                    foreach (str_split($right) as $char) { // счётчик по строке быстрее
                        if (empty($charsMap[$char] ?? null)) {
                            $fail("Элементы массива rights элементов массива :attribute должны содержать только символы из значений $this->termsKey и $this->nonTermsKey.");
                            return;
                        }
                    }
                }
            }
        }

        if (!$hasRuleForRoot) {
            $fail("В значении :attribute должно присутствовать правило для $this->rootTermKey.");
            return;
        }
    }

    public function setData(array $data): static
    {
        $dotData = Arr::dot($data);
        $this->terms = str_split($dotData[$this->termsKey] ?? '');
        $this->nonTerms = str_split($dotData[$this->nonTermsKey] ?? '');
        $this->rootTerm = $dotData[$this->rootTermKey] ?? '';

        return $this;
    }
}
