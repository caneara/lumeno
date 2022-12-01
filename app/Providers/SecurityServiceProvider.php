<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot() : void
    {
        Password::defaults(fn() => $this->passwordDefaults());
    }

    /**
     * Retrieve the default security protections required for passwords.
     *
     */
    protected function passwordDefaults() : Password
    {
        return Password::min(12)
            ->letters()
            ->numbers()
            ->symbols()
            ->mixedCase()
            ->uncompromised();
    }
}
