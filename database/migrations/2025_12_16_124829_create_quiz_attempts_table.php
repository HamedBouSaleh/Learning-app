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
        $table->unsignedBigInteger('quiz_id');
        $table->unsignedBigInteger('user_id');
        $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->integer('score')->default(0);
        $table->integer('total_points');
        $table->decimal('percentage', 5, 2)->nullable();
        $table->integer('time_spent_seconds')->nullable();
        $table->timestamp('attempt_date')->useCurrent();
        $table->timestamp('completed_at')->nullable();
        $table->integer('attempt_number')->default(1);
        $table->timestamps();
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
