<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'name',
        'role',
        'group_name',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'role' => UserRole::class,
    ];

    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class)
            ->using(AssignedTask::class);
    }
}
