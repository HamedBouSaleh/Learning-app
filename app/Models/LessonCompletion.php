<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    protected $fillable = [
        'lesson_id',
        'user_id',
        'completed_at',
        'time_spent_seconds'
    ];
}