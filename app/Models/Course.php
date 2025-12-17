<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'category',
        'difficulty',
        'thumbnail_url',
        'estimated_duration',
        'created_by',
        'is_published',
        'enrollment_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'enrollment_count' => 'integer',
        'estimated_duration' => 'integer',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }
}
