<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningOfficial extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'fname', 
        'middle_initial', 
        'lname', 
        'position', 
        'age', 
        'address', 
        'gender', 
        'birthdate', 
        'platform', 
        'credentials', 
        'email', 
        'phone', 
        'photo'
    ];

    // Casts for attributes
    protected $casts = [
        'platform' => 'array',
        'credentials' => 'array',
        'birthdate' => 'date',
    ];

    // Optional: full name accessor
    public function getFullNameAttribute()
    {
        return "{$this->fname} {$this->middle_initial}. {$this->lname}";
    }

    // Relationship with feedbacks
    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }
}
