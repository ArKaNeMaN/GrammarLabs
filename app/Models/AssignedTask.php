<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssignedTask extends Pivot
{
    protected $table = 'assigned_tasks';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'task_id',
    ];

    protected $with = [
        'task',
        'user',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TaskAnswer::class, 'assigned_task_id')
            ->where('type', $this->task()->select('type'));
    }

    public function lastAnswer(): HasOne
    {
        return $this->hasOne(TaskAnswer::class, 'assigned_task_id')
            ->where('type', $this->task()->select('type'))
            ->latestOfMany();
    }
}
