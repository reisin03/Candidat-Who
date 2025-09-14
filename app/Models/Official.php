<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'middle_initial', 'lname', 'age', 'gender', 'birthdate', 'position', 'phone', 'email', 'description', 'photo', 'platform', 'credentials',
    ];

    protected $casts = [
        'platform' => 'array',
        'credentials' => 'array',
        'birthdate' => 'date',
    ];

    // Optional: full name accessor
    public function getFullNameAttribute()
    {
        $fullName = $this->fname;
        if ($this->middle_initial) {
            $fullName .= ' ' . $this->middle_initial;
        }
        $fullName .= ' ' . $this->lname;
        return $fullName;
    }

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }
}
