<?php

namespace App\Actions\User;

use App\Models\User;
use App\Types\Action;
use Illuminate\Support\Arr;
use App\Actions\Image\UpdateAction as ImageAction;
use App\Notifications\VerifyEmailAddressNotification;

class UpdateAction extends Action
{
    /**
     * Update the given user using the given payload.
     *
     */
    public static function execute(User $user, array $payload) : User
    {
        $payload = static::prepare($user, $payload);

        ImageAction::execute($user, 'avatar', $payload['avatar'] ?? null);

        $attributes = Arr::except($payload, 'avatar');

        return attempt(fn() => tap($user)->update($attributes));
    }

    /**
     * Prepare the given payload for use.
     *
     */
    protected static function prepare(User $user, array $payload) : array
    {
        if (Arr::exists($payload, 'email')) {
            if ($user->email !== $payload['email']) {
                $payload['email_verified_at'] = null;

                $user->notify(new VerifyEmailAddressNotification());
            }
        }

        return $payload;
    }
}
