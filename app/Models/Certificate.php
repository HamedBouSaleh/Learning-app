<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_url',
        'verification_code',
        'generated_at',
        'instructor_name'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'course_id' => 'integer',
        'generated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
