<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'lesson_type',
        'order_position',
        'estimated_duration'
    ];

    protected $casts = [
        'course_id' => 'integer',
        'order_position' => 'integer',
        'estimated_duration' => 'integer',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function lessonCompletions()
    {
        return $this->hasMany(LessonCompletion::class);
    }
}
