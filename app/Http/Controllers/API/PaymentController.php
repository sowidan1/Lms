<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\payment\ValidateCheckOutRequest;
use App\Services\Facades\PaymentFacade;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function createCheckoutSession(ValidateCheckOutRequest $request)
    {
        if ($this->isStudent()) {
            return apiError(error: 'Only students can subscribe to courses', code: 403);
        }

        return PaymentFacade::createCheckoutSession(Auth::user(), $request->validated()['course_id']);
    }

    public function cancelSubscription(ValidateCheckOutRequest $request)
    {
        if ($this->isStudent()) {
            return apiError(error: 'Only students can cancel subscriptions', code: 403);
        }

        return PaymentFacade::cancelSubscription(Auth::user(), $request->validated()['course_id']);
    }

    protected function isStudent()
    {
        return Auth::user()->role === \App\Models\User::ROLE_STUDENT;
    }
}
