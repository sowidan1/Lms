<?php

namespace App\Services\Contract;

interface PaymentContract
{
    public function createCheckoutSession($user, $courseId);

    public function cancelSubscription($user, $courseId);
}
