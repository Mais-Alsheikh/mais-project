<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'answers',
        'score',
        'percentage',
        'started_at',
        'submitted_at',
        'duration_seconds',
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
