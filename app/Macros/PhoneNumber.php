<?php

namespace App\Macros;

use Propaganistas\LaravelPhone\PhoneNumber as Facade;

class PhoneNumber
{
    /**
     * Register the phone number macros.
     *
     */
    public static function macros() : void
    {
        static::is();
    }

    /**
     * Register the 'is' macro.
     *
     */
    protected static function is() : void
    {
        Facade::macro('is', fn($item) => Facade::__toString() === $item->__toString());
    }
}
