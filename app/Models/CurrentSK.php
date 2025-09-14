<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentSK extends Model
{
    use HasFactory;

    protected $table = 'current_sks'; // ensure this matches your table name

    protected $fillable = [
        'fname',
        'middle_initial',
        'lname',
        'age',
        'address',
        'gender',
        'birthdate',
        'platform',
        'credentials',
        'photo',
        'position',
        'email',
        'phone',
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
            $fullName .= ' ' . $this->middle_initial . '.';
        }
        $fullName .= ' ' . $this->lname;
        return $fullName;
    }

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }
}
