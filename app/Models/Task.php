<?php

namespace App\Models;

use App\Enums\TaskType;
use App\Grammars\Casts\TaskParams;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'type',
        'params',
    ];

    protected $casts = [
        'type' => TaskType::class,
        'params' => TaskParams::class,
    ];
}
