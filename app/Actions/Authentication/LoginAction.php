<?php

namespace App\Actions\Authentication;

use App\Types\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginAction extends Action
{
    /**
     * Sign the user into the application.
     *
     */
    public static function execute(array $payload) : void
    {
        static::verify($payload);

        session()->regenerate();
    }

    /**
     * Register a failed attempt to authenticate.
     *
     */
    protected static function fail(string $key) : void
    {
        RateLimiter::hit($key);

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Prevent further authentication requests.
     *
     */
    protected static function throttle(string $key) : void
    {
        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     */
    protected static function verify(array $payload) : mixed
    {
        $key = Str::lower($payload['email'] . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return static::throttle($key);
        }

        $credentials = Arr::only($payload, ['email', 'password']);

        return Auth::attempt($credentials, $payload['remember'] ?? false)
            ? RateLimiter::clear($key)
            : static::fail($key);
    }
}
