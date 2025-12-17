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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('certificate_url')->nullable();
            $table->string('verification_code')->unique();
            $table->timestamp('generated_at')->useCurrent();
            $table->string('instructor_name')->nullable();
            
            $table->unique(['user_id', 'course_id'], 'unique_user_course_certificate');
            $table->index('user_id', 'idx_user_id');
            $table->index('course_id', 'idx_course_id');
            $table->index('verification_code', 'idx_verification_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
