<?php

namespace App\Types;

use Closure;
use App\Exceptions\AccessDeniedException;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    /**
     * Deny the user access when the given conditional is negative.
     *
     */
    public function denyIf(bool $conditional, string | Closure $message = '') : bool
    {
        if (! $conditional) {
            return true;
        }

        if (! $message) {
            return false;
        }

        throw new AccessDeniedException(
            is_string($message) ? $message : $message()
        );
    }
}
