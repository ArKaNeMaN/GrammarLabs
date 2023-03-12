<?php

namespace App\Models;

use App\Enums\AssignedTaskAnswerStatus;
use App\Enums\TaskType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskAnswer extends Model
{
    protected $table = 'assigned_tasks_answers';

    protected $fillable = [
        'type',
        'answer',
        'status',
        'comment',
    ];

    protected $casts = [
        'answer' => \App\Grammars\Casts\TaskAnswer::class,
        'type' => TaskType::class,
        'status' => AssignedTaskAnswerStatus::class,
    ];

    public function assignedTask(): BelongsTo
    {
        return $this->belongsTo(AssignedTask::class, 'assigned_task_id');
    }
}
