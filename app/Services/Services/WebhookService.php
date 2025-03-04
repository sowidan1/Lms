<?php

namespace App\Services\Services;

use App\Jobs\SendMail;
use App\Mail\SubscriptionStarted;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Contract\WebhookContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WebhookService implements WebhookContract
{
    public function handleWebhook($request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($event->data->object);
                    break;

                case 'customer.subscription.deleted':
                    $this->handleSubscriptionDeleted($event->data->object);
                    break;

                case 'customer.subscription.updated':
                    $this->handleSubscriptionUpdated($event->data->object);
                    break;
            }

            return apiSuccess(
                data: [],
                message: 'Webhook handled successfully',
                code: 200
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return apiError(error: 'Invalid webhook signature', code: 400);
        } catch (\Exception $e) {
            return apiError(error: $e->getMessage(), code: 400);
        }
    }

    private function handleCheckoutSessionCompleted($session)
    {
        $user = User::findOrFail($session->metadata->user_id);
        $course = Course::findOrFail($session->metadata->course_id);

        Subscription::updateOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ],
            [
                'id' => Str::ulid(),
                'stripe_subscription_id' => $session->subscription,
                'status'  => Course::ACTIVE_STATUS,
                'ends_at' => null,
            ]
        );

        dispatch(new SendMail($user, $course));
    }

    private function handleSubscriptionDeleted($subscription)
    {
        $userSubscription = Subscription::where('stripe_subscription_id', $subscription->id)->first();
        if ($userSubscription) {
            $userSubscription->update([
                'status'  => Course::INACTIVE_STATUS,
                'ends_at' => now(),
            ]);
        }
    }

    private function handleSubscriptionUpdated($subscription)
    {
        $userSubscription = Subscription::where('stripe_subscription_id', $subscription->id)->first();
        if ($userSubscription) {
            $status = $subscription->status === Course::ACTIVE_STATUS ? Course::ACTIVE_STATUS : Course::INACTIVE_STATUS;
            $userSubscription->update([
                'status'  => $status,
                'ends_at' => $subscription->cancel_at ? now()->addSeconds($subscription->cancel_at) : null,
            ]);
        }
    }
}
