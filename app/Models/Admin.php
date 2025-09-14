<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'id_document',
        'verification_status',
        'verification_notes',
        'is_super_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * Check if the admin is verified
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    /**
     * Check if the admin is pending verification
     */
    public function isPendingVerification(): bool
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Check if the admin verification was rejected
     */
    public function isVerificationRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }

    /**
     * Check if the admin is a super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    /**
     * Get the admin who verified this admin
     */
    public function verifiedBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'verified_by');
    }

    /**
     * Get users verified by this admin
     */
    public function verifiedUsers()
    {
        return $this->hasMany(\App\Models\User::class, 'verified_by');
    }

    /**
     * Get admins verified by this admin
     */
    public function verifiedAdmins()
    {
        return $this->hasMany(\App\Models\Admin::class, 'verified_by');
    }
}
