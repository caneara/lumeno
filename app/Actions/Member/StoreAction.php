<?php

namespace App\Actions\Member;

use App\Models\User;
use App\Types\Action;
use App\Models\Organization;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterAndEnlistNotification;

class StoreAction extends Action
{
    /**
     * Create a new member using the given organization, email and role.
     *
     */
    public static function execute(Organization $organization, string $email, int $role) : bool
    {
        $user = User::firstWhere('email', $email);

        if (blank($user)) {
            return static::invite($organization, $email, $role);
        }

        $payload = [
            'user_id' => $user->id,
            'role'    => $role,
        ];

        return ! ! attempt(fn() => $organization->members()->create($payload));
    }

    /**
     * Send an email inviting a person to register and enlist in the organization.
     *
     */
    public static function invite(Organization $organization, string $email, int $role) : bool
    {
        $payload = encrypt([
            'organization' => $organization->id,
            'role'         => $role,
        ]);

        $notification = new RegisterAndEnlistNotification($organization->name, $payload);

        Notification::route('mail', $email)->notify($notification);

        return false;
    }
}
