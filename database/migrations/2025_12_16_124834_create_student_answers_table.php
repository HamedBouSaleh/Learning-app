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
        $table->unsignedBigInteger('quiz_attempt_id');
        $table->unsignedBigInteger('question_id');
        $table->unsignedBigInteger('answer_id')->nullable();
        $table->foreign('quiz_attempt_id')->references('id')->on('quiz_attempts')->onDelete('cascade');
        $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        $table->foreign('answer_id')->references('id')->on('answers')->onDelete('set null');
        $table->text('short_answer_text')->nullable();
        $table->boolean('is_correct')->default(false);
        $table->timestamps();
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
