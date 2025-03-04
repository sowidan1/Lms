<?php

namespace App\Services\Facades;

use App\Services\Services\WebhookService;
use Illuminate\Support\Facades\Facade;

class WebhookFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return WebhookService::class;
    }
}
