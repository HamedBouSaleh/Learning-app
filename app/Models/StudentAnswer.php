<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $table = 'student_answers';

    public $timestamps = false;

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'answer_id',
        'short_answer_text',
        'is_correct'
    ];

    protected $casts = [
        'quiz_attempt_id' => 'integer',
        'question_id' => 'integer',
        'answer_id' => 'integer',
        'is_correct' => 'boolean',
    ];

    // Relationships
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
