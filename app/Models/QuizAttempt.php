<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total_points',
        'percentage',
        'time_spent_seconds',
        'attempt_date',
        'completed_at',
        'attempt_number'
    ];
}