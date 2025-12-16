<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
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
}