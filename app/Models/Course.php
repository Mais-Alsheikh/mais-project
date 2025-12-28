<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'teacher_id',
         'price',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
