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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('lesson_type', ['Video', 'Article', 'Mixed'])->default('Video');
            $table->integer('order_position');
            $table->integer('estimated_duration')->nullable()->comment('Duration in minutes');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('course_id', 'idx_course_id');
            $table->index('order_position', 'idx_order_position');
            $table->index('lesson_type', 'idx_lesson_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
