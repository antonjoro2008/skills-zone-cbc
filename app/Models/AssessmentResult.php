<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_user_id',
        'classroom_id',
        'subject',
        'assessment_title',
        'score_percent',
        'assessed_at',
    ];

    protected $casts = [
        'assessed_at' => 'datetime',
    ];

    public function learner()
    {
        return $this->belongsTo(User::class, 'learner_user_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}

