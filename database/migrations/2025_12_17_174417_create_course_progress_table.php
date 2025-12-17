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
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_lessons')->default(0);
            $table->integer('completed_lessons')->default(0);
            $table->integer('total_quizzes')->default(0);
            $table->integer('completed_quizzes')->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            
            $table->unique(['user_id', 'course_id'], 'unique_user_course');
            $table->index('course_id', 'idx_course_id');
            $table->index('user_id', 'idx_user_id');
            $table->index('progress_percentage', 'idx_progress_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_progress');
    }
};
