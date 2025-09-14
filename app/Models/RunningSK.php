<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningSK extends Model
{
    use HasFactory;

    protected $table = 'running_sks'; // ✅ tell Eloquent the exact table name


    protected $fillable = [
        'fname',
        'middle_initial',
        'lname',
        'position',
        'age',
        'address',
        'gender',
        'birthdate',
        'photo',
        'platform',
        'credentials',
        'email',
        'phone',
    ];

    protected $casts = [
        'platform' => 'array',
        'credentials' => 'array',
    ];

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }
}
