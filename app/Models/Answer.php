<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
        'order_position'
    ];

    protected $casts = [
        'question_id' => 'integer',
        'is_correct' => 'boolean',
        'order_position' => 'integer',
    ];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
