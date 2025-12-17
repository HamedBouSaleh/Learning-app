<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    use HasFactory;

    protected $table = 'lesson_completion';

    public $timestamps = false;

    protected $fillable = [
        'lesson_id',
        'user_id',
        'completed_at',
        'time_spent_seconds'
    ];

    protected $casts = [
        'lesson_id' => 'integer',
        'user_id' => 'integer',
        'completed_at' => 'datetime',
        'time_spent_seconds' => 'integer',
    ];

    // Relationships
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
