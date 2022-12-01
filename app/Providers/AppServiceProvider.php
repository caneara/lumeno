<?php

namespace App\Providers;

use App\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot() : void
    {
        //
    }

    /**
     * Register any application services.
     *
     */
    public function register() : void
    {
        Carbon::useImmutable();
    }
}
