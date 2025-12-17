<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'quiz_attempts';

    public $timestamps = false;

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

    protected $casts = [
        'quiz_id' => 'integer',
        'user_id' => 'integer',
        'score' => 'integer',
        'total_points' => 'integer',
        'percentage' => 'decimal:2',
        'time_spent_seconds' => 'integer',
        'attempt_date' => 'datetime',
        'completed_at' => 'datetime',
        'attempt_number' => 'integer',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
