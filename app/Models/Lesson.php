<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'type',
        'file_path',
        'content_path',
        'video_url',
        'video_preview',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}