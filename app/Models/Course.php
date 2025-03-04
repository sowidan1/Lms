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

    CONST ACTIVE_STATUS = 'active';

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }
}
