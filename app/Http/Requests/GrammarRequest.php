<?php

namespace App\Http\Requests;

use App\Http\Validation\Rules\CharsSet;
use App\Http\Validation\Rules\ContainsOnlyFrom;
use App\Http\Validation\Rules\GrammarRules;
use App\Http\Validation\Rules\NotIncludedCharsFrom;
use Illuminate\Foundation\Http\FormRequest;

class GrammarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'terms' => ['required', 'string', 'min:1', new CharsSet()],
            'non_terms' => ['required', 'string', 'min:1', new CharsSet(), new NotIncludedCharsFrom('terms')],
            'root_term' => ['required', 'string', 'size:1', new ContainsOnlyFrom('non_terms')],
            'rules' => ['required', 'array', new GrammarRules('terms', 'non_terms', 'root_term')],
        ];
    }
}
