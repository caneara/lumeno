<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;

class UserPolicy extends Policy
{
    /**
     * Determine whether the user can upload files.
     *
     */
    public function uploadFiles(User $user) : bool
    {
        $key = "upload-files:{$user->id}";

        if (! RateLimiter::attempt($key, 10, fn() => true)) {
            abort(Response::HTTP_TOO_MANY_REQUESTS);
        }

        return true;
    }
}
