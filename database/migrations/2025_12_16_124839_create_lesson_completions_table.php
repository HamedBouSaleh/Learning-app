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
    Schema::create('lesson_completions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lesson_id');
        $table->unsignedBigInteger('user_id');
        $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamp('completed_at')->useCurrent();
        $table->integer('time_spent_seconds')->nullable();
        $table->unique(['lesson_id', 'user_id']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_completions');
    }
};
