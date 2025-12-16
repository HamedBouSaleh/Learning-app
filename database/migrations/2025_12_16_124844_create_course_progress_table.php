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
    Schema::create('course_progresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->integer('total_lessons')->default(0);
        $table->integer('completed_lessons')->default(0);
        $table->integer('total_quizzes')->default(0);
        $table->integer('completed_quizzes')->default(0);
        $table->decimal('progress_percentage', 5, 2)->default(0.00);
        $table->unique(['course_id', 'user_id']);
        $table->timestamps();
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
