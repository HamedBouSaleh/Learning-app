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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_url');
            $table->enum('file_type', ['PDF', 'Image', 'Document']);
            $table->integer('file_size_kb')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            
            $table->index('lesson_id', 'idx_lesson_id');
            $table->index('file_type', 'idx_file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
