<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    use HasFactory;

    protected $table = 'course_progress';

    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'user_id',
        'total_lessons',
        'completed_lessons',
        'total_quizzes',
        'completed_quizzes',
        'progress_percentage',
        'last_updated'
    ];

    protected $casts = [
        'course_id' => 'integer',
        'user_id' => 'integer',
        'total_lessons' => 'integer',
        'completed_lessons' => 'integer',
        'total_quizzes' => 'integer',
        'completed_quizzes' => 'integer',
        'progress_percentage' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
