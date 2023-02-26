<?php

namespace App\Http\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CharsSet implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('Значение :attribute должно быть строкой.');
            return;
        }

        if (!preg_match('/^[a-zA-Z1-9]+$/i', $value)) {
            $fail('Значение :attribute должно состоять только из латинских символов и/или цифр.');
            return;
        }

        if (strlen(count_chars($value, 3)) !== strlen($value)) {
            $fail('Символы в значении :attribute не должны повторяться.');
            return;
        }
    }
}
