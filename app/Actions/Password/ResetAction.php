<?php

namespace App\Actions\Password;

use App\Models\User;
use App\Types\Action;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetAction extends Action
{
    /**
     * Reset the password of the user associated with the given payload.
     *
     */
    public static function execute(array $payload) : void
    {
        $result = Password::broker()->reset($payload, function($user, $password) {
            return static::update($user, $password);
        });

        if ($result === Password::PASSWORD_RESET) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => [trans($result)],
        ]);
    }

    /**
     * Assign the given password to the given user.
     *
     */
    protected static function update(User $user, string $password) : void
    {
        $payload = [
            'password'       => $password,
            'remember_token' => Str::random(60),
        ];

        attempt(fn() => $user->update($payload));

        Auth::login($user);
    }
}
