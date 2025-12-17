<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    public $timestamps = false;

    protected $fillable = [
        'lesson_id',
        'file_name',
        'file_url',
        'file_type',
        'file_size_kb',
        'uploaded_at'
    ];

    protected $casts = [
        'lesson_id' => 'integer',
        'file_size_kb' => 'integer',
        'uploaded_at' => 'datetime',
    ];

    // Relationships
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
