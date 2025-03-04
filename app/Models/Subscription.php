<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'course_id', 'stripe_subscription_id', 'status', 'ends_at'];
}
