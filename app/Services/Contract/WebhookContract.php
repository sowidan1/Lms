<?php

namespace App\Services\Contract;

use Illuminate\Http\Request;

interface WebhookContract
{
    public function handleWebhook(Request $request);
}
