<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'email',
        'phone',
        'address',
        'motto',
        'theme_color',
    ];

    protected $casts = [
        'theme_color' => 'string',
    ];

    /**
     * Get the users (learners) that belong to the institution.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the learners (students) that belong to the institution.
     */
    public function learners()
    {
        return $this->hasMany(User::class)->where('user_type', 'student');
    }
}
