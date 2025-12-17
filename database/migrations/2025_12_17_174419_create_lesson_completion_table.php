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
        Schema::create('lesson_completion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('completed_at')->useCurrent();
            $table->integer('time_spent_seconds')->default(0);
            
            $table->unique(['user_id', 'lesson_id'], 'unique_user_lesson');
            $table->index('lesson_id', 'idx_lesson_id');
            $table->index('user_id', 'idx_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_completion');
    }
};
