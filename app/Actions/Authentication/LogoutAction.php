<?php

namespace App\Actions\Authentication;

use App\Types\Action;
use Illuminate\Support\Facades\Auth;

class LogoutAction extends Action
{
    /**
     * Sign the user out of the application.
     *
     */
    public static function execute() : void
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();
    }
}
