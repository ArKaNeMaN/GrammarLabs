<?php

namespace App\Models;

use App\Enums\AnswerAutoTestResult;
use App\Enums\AnswerStatus;
use App\Enums\TaskType;
use App\Exceptions\Tasks\Answers\AnswerAlreadyChecked;
use App\Exceptions\Tasks\Answers\AnswerNotSent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Throwable;

class TaskAnswer extends Model
{
    protected $table = 'assigned_tasks_answers';

    protected $fillable = [
        'type',
        'answer',
        'auto_test_result',
        'status',
        'comment',
    ];

    protected $casts = [
        'answer' => \App\Grammars\Casts\TaskAnswer::class,
        'type' => TaskType::class,
        'status' => AnswerStatus::class,
        'auto_test_result' => AnswerAutoTestResult::class,
    ];

    public function assignedTask(): BelongsTo
    {
        return $this->belongsTo(AssignedTask::class, 'assigned_task_id');
    }

    /**
     * @throws AnswerNotSent
     * @throws AnswerAlreadyChecked
     * @throws Throwable
     */
    protected function setCheckStatus(AnswerStatus $status): void
    {
        if ($this->status === AnswerStatus::DRAFT) {
            throw new AnswerNotSent();
        }

        if ($this->status !== AnswerStatus::SENT) {
            throw new AnswerAlreadyChecked();
        }

        $this->status = $status;
        $this->saveOrFail();
    }

    /**
     * @throws AnswerAlreadyChecked
     * @throws Throwable
     * @throws AnswerNotSent
     */
    public function reject(): void
    {
        $this->setCheckStatus(AnswerStatus::REJECTED);
    }

    /**
     * @throws AnswerAlreadyChecked
     * @throws Throwable
     * @throws AnswerNotSent
     */
    public function accept(): void
    {
        $this->setCheckStatus(AnswerStatus::ACCEPTED);
    }
}
