<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assigned_tasks', static function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users');

            $table->foreignId('task_id')
                ->constrained('tasks');

            $table->unique(['task_id', 'user_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assigned_tasks');
    }
};
