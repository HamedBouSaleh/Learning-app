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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('total_points');
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->integer('time_spent_seconds')->default(0);
            $table->timestamp('attempt_date')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->integer('attempt_number');
            
            $table->index('quiz_id', 'idx_quiz_id');
            $table->index('user_id', 'idx_user_id');
            $table->index('attempt_date', 'idx_attempt_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
