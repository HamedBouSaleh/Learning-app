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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamp('last_accessed_at')->nullable();
            $table->enum('status', ['Active', 'Completed', 'Dropped'])->default('Active');
            
            $table->unique(['user_id', 'course_id'], 'unique_user_course_enrollment');
            $table->index('user_id', 'idx_user_id');
            $table->index('course_id', 'idx_course_id');
            $table->index('status', 'idx_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
