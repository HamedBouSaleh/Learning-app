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
        $table->unsignedBigInteger('course_id');
        $table->unsignedBigInteger('lesson_id')->nullable();
        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        $table->string('title', 200);
        $table->text('description')->nullable();
        $table->integer('passing_score')->default(70)->comment('Percentage');
        $table->integer('time_limit')->nullable()->comment('Minutes');
        $table->boolean('shuffle_questions')->default(false);
        $table->boolean('show_correct_answers')->default(true);
        $table->boolean('allow_retake')->default(true);
        $table->integer('max_attempts')->default(3);
        $table->timestamps();
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
