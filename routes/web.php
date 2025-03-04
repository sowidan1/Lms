<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/payment/success', function (Request $request) {
    $sessionId = $request->get('session_id');

    if (!$sessionId) {
        return response()->json(['error' => 'No session ID provided'], 400);
    }

    try {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Log or process the session as needed
        return response()->json([
            'success' => true,
            'message' => 'Payment processed',
            'session_data' => $session
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('payment.success');

Route::get('/payment/cancel', function () {
    return response()->json(['message' => 'Payment cancelled']);
})->name('payment.cancel');
