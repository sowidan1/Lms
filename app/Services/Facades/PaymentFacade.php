<?php

namespace App\Services\Facades;

use App\Services\Services\PaymentService;
use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentService::class;
    }
}
