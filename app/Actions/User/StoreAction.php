<?php

namespace App\Actions\User;

use App\Models\User;
use App\Types\Action;

class StoreAction extends Action
{
    /**
     * Create a new user using the given payload and type.
     *
     */
    public static function execute(array $payload, int $type) : User
    {
        $attributes = array_merge($payload, ['type' => $type]);

        return attempt(fn() => User::create($attributes));
    }
}
