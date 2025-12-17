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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('answer_id')->nullable()->constrained('answers')->onDelete('set null')->comment('Nullable for short answer questions');
            $table->text('short_answer_text')->nullable();
            $table->boolean('is_correct')->default(false);
            
            $table->index('quiz_attempt_id', 'idx_quiz_attempt_id');
            $table->index('question_id', 'idx_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
