<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\WebhookController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// *-------------------PUBLIC ROUTES-------------------*

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/webhook', [WebhookController::class, 'handleWebhook']);


// *-------------------PROTECTED ROUTES-------------------*

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::post('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

    Route::post('/payment/checkout', [PaymentController::class, 'createCheckoutSession']);
    Route::post('/payment/cancel', [PaymentController::class, 'cancelSubscription']);

});

