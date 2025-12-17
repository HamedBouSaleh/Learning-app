<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('passing_score');
            $table->integer('time_limit')->nullable()->comment('Time limit in minutes');
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('show_correct_answers')->default(true);
            $table->boolean('allow_retake')->default(true);
            $table->integer('max_attempts')->default(3);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('course_id', 'idx_course_id');
            $table->index('lesson_id', 'idx_lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
