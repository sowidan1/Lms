<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionStarted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Course $course;
    public User $user;

    public function __construct(Course $course, User $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Subscription Has Started!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_started',
            with: [
                'course' => $this->course,
                'user' => $this->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
