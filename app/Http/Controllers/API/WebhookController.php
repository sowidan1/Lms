<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Facades\WebhookFacade;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        return WebhookFacade::handleWebhook($request);
    }
}
