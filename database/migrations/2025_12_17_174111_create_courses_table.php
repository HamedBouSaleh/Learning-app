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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description', 500)->nullable();
            $table->text('long_description')->nullable();
            $table->string('category', 100)->nullable();
            $table->enum('difficulty', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->string('thumbnail_url')->nullable();
            $table->integer('estimated_duration')->nullable()->comment('Duration in minutes');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('is_published')->default(false);
            $table->integer('enrollment_count')->default(0);
            
            $table->index('category', 'idx_category');
            $table->index('difficulty', 'idx_difficulty');
            $table->index('is_published', 'idx_is_published');
            $table->index('created_by', 'idx_created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
