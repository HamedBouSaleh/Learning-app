<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'total_lessons',
        'completed_lessons',
        'total_quizzes',
        'completed_quizzes',
        'progress_percentage'
    ];
}