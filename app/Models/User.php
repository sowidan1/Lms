<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use HasUlids;

    const ROLE_ADMIN = 'admin';
    const ROLE_INSTRUCTOR = 'instructor';
    const ROLE_STUDENT = 'student';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'stripe_customer_id'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, Subscription::class, 'user_id', 'id', 'id', 'course_id')
            ->where('subscriptions.status', Course::ACTIVE_STATUS);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
