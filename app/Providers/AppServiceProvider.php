<?php

namespace App\Providers;

use App\Services\Services\PaymentService;
use App\Services\Services\WebhookService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('PaymentService',function(){
            return new PaymentService();
        });

        $this->app->bind('WebhookService',function(){
            return new WebhookService();
        });
    }

    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->uncompromised();
        });
    }
}
