<?php

namespace App\Http\Requests;

use App\Enums\TaskType;
use App\Http\Validation\Rules\CharsSet;
use App\Http\Validation\Rules\ContainsOnlyFrom;
use App\Http\Validation\Rules\GrammarRules;
use App\Http\Validation\Rules\NotIncludedCharsFrom;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', new Enum(TaskType::class)],
            'params' => ['required', 'array'],
            ...match (TaskType::tryFrom($this->input('type'))) {
                TaskType::GENERATE => [
                    'params.required_str_count' => ['required', 'numeric', 'integer', 'min:1'],
                    'params.grammar.terms' => ['required', 'string', 'min:1', new CharsSet()],
                    'params.grammar.non_terms' => ['required', 'string', 'min:1', new CharsSet(), new NotIncludedCharsFrom('params.grammar.terms')],
                    'params.grammar.root_term' => ['required', 'string', 'size:1', new ContainsOnlyFrom('params.grammar.non_terms')],
                    'params.grammar.rules' => ['required', 'array', new GrammarRules("params.grammar.terms", 'params.grammar.non_terms', 'params.grammar.root_term')],
                ],
                TaskType::REVERSE => [
                    'params.input_strings' => ['required', 'array', 'min:1'],
                    'params.input_strings.*' => ['required', 'string', 'min:1'],
                ],
                default => [],
            },
        ];
    }
}
