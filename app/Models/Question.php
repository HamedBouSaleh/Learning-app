<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'order_position',
        'points'
    ];

    protected $casts = [
        'quiz_id' => 'integer',
        'order_position' => 'integer',
        'points' => 'integer',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
