<?php

namespace App\Macros;

use Illuminate\Http\RedirectResponse as Facade;

class RedirectResponse
{
    /**
     * Register the redirect response macros.
     *
     */
    public static function macros() : void
    {
        static::notify();
        static::withData();
    }

    /**
     * Register the 'notify' macro.
     *
     */
    protected static function notify() : void
    {
        Facade::macro('notify', function($message, $type = 'success', $fixed = false) {
            return tap($this)->with('notification', compact('message', 'type', 'fixed'));
        });
    }

    /**
     * Register the 'with data' macro.
     *
     */
    protected static function withData() : void
    {
        Facade::macro('withData', function(string $key, mixed $value) {
            return tap($this)->with("data.{$key}", $value);
        });
    }
}
