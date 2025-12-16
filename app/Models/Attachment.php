<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'lesson_id',
        'file_name',
        'file_url',
        'file_type',
        'file_size_kb'
    ];
}