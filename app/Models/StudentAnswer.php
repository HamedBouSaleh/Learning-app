<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'answer_id',
        'short_answer_text',
        'is_correct'
    ];
}