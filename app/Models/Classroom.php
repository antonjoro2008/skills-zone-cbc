<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'teacher_user_id',
        'name',
        'grade_level',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    public function learners()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id')
            ->withTimestamps();
    }
}

