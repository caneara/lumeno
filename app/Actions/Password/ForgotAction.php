<?php

namespace App\Actions\Password;

use App\Types\Action;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotAction extends Action
{
    /**
     * Send a reset link to the user with the given email address.
     *
     */
    public static function execute(array $email) : void
    {
        $result = Password::broker()->sendResetLink($email);

        if ($result === Password::RESET_LINK_SENT) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => [trans($result)],
        ]);
    }
}
