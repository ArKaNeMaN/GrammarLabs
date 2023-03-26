<?php

use App\Enums\AnswerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assigned_tasks_answers', static function (Blueprint $table): void {
            $table->id();

            $table->foreignId('assigned_task_id')
                ->constrained('assigned_tasks');

            $table->string('type')
                ->index();

            $table->json('answer');
            $table->string('auto_test_result')
                ->nullable()
                ->index();

            $table->string('status')
                ->default(AnswerStatus::DRAFT->value)
                ->index();
            $table->text('comment')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assigned_tasks_answers');
    }
};
