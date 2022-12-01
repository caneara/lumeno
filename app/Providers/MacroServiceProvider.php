<?php

namespace App\Providers;

use App\Macros\Builder;
use App\Macros\PhoneNumber;
use App\Macros\Notification;
use App\Macros\TestResponse;
use App\Macros\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot() : void
    {
        Builder::macros();
        PhoneNumber::macros();
        Notification::macros();
        TestResponse::macros();
        RedirectResponse::macros();
    }
}
