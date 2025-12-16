<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'lesson_id',
        'title',
        'description',
        'passing_score',
        'time_limit',
        'shuffle_questions',
        'show_correct_answers',
        'allow_retake',
        'max_attempts'
    ];
}