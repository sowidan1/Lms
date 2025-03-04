<?php

namespace App\Jobs;

use App\Mail\SubscriptionStarted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Queueable;

    protected $user;

    protected $course;

    public function __construct($user, $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SubscriptionStarted($this->course, $this->user));

    }
}
