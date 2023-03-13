<?php

namespace App\Http\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArrayOfNonEmpty implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail('Значение :attribute должно быть массивом.');
            return;
        }

        foreach ($value as $item) {
            if (empty($item)) {
                $fail('Поле :attribute не может содержать пустые элементы.');
                return;
            }
        }
    }
}
