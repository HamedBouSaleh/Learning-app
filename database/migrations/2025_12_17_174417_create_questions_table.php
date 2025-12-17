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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['MCQ', 'MSQ', 'TrueFalse', 'ShortAnswer']);
            $table->integer('order_position');
            $table->integer('points')->default(1);
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('quiz_id', 'idx_quiz_id');
            $table->index('order_position', 'idx_order_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
