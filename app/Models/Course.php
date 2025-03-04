<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasUlids;

    protected $fillable = [
        'title',
        'description',
        'price',
        'instructor_id',
    ];

    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'course_id');
    }
}
