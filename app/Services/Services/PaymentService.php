<?php

namespace App\Services\Services;

use App\Services\Contract\PaymentContract;
use App\Models\Course;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription as StripeSubscription;

class PaymentService implements PaymentContract
{
    public function createCheckoutSession($user, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if ($user->subscriptions()->where('course_id', $course->id)->where('status', Course::ACTIVE_STATUS)->exists()) {
            return apiError(error: 'You are already subscribed to this course', code: 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'customer_email' => $user->email,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => ['name' => $course->title],
                    'unit_amount'  => $course->price * 100,
                    'recurring'    => ['interval' => 'month'],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('payment.success', ['session_id' => 'REPLACE_ME']),
            'cancel_url'  => route('payment.cancel'),
            'metadata'    => [
                'course_id' => $course->id,
                'user_id'   => $user->id,
            ],
        ]);

        $session->success_url = str_replace('REPLACE_ME', $session->id, $session->success_url);

        return apiSuccess(
            data   : ['checkout_url' => $session->url],
            message: 'Checkout session created successfully',
            code   : 200
        );
    }

    public function cancelSubscription($user, $courseId)
    {
        $subscription = $user->subscriptions()->where('course_id', $courseId)->first();

        if (!$subscription || $subscription->status !== Course::ACTIVE_STATUS) {
            return apiError(error: 'No active subscription found', code: 404);
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_subscription_id);
        $stripeSubscription->cancel();

        $subscription->update([
            'status'  => Course::INACTIVE_STATUS,
            'ends_at' => now(),
        ]);

        return apiSuccess(
            data   : null,
            message: 'Subscription cancelled successfully',
            code   : 200
        );
    }
}
