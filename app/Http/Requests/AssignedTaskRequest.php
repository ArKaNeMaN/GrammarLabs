<?php

namespace App\Http\Requests;

use App\Enums\TaskType;
use App\Http\Validation\Rules\CharsSet;
use App\Http\Validation\Rules\ContainsOnlyFrom;
use App\Http\Validation\Rules\GrammarRules;
use App\Http\Validation\Rules\NotIncludedCharsFrom;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AssignedTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'task_id' => ['required', 'exists:tasks,id'],
            'preserve_page' => ['nullable', 'boolean'],
        ];
    }
}
