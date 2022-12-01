<?php

namespace App\Actions\Invitation;

use App\Models\User;
use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Organization;
use Illuminate\Support\Collection;
use App\Actions\Organization\UsageAction;
use Laravel\Paddle\Exceptions\PaddleException;
use Illuminate\Contracts\Cache\LockTimeoutException;

class StoreAction extends Action
{
    /**
     * The response codes.
     *
     */
    public const SUCCESS       = 0;
    public const LOCKED_OUT    = 1;
    public const PAYMENT_ERROR = 2;

    /**
     * Create a new invitation using the given vacancy and user.
     *
     */
    public static function execute(Organization $organization, Vacancy $vacancy, User | Collection $target) : int
    {
        $lock = cache()->lock($vacancy->id, 30);

        $users = $target instanceof User ? collect([$target->id]) : $target;

        try {
            $lock->get(fn() => static::workflow($organization, $vacancy, $users));
        } catch (LockTimeoutException) {
            return static::LOCKED_OUT;
        } catch (PaddleException) {
            return static::PAYMENT_ERROR;
        }

        return static::SUCCESS;
    }

    /**
     * The steps to perform when sending invitations.
     *
     */
    protected static function workflow(Organization $organization, Vacancy $vacancy, Collection $users) : void
    {
        UsageAction::execute($organization, $vacancy, $users->count());

        $invites = $users->map(fn($user) => [
            'organization_id' => $vacancy->organization_id,
            'user_id'         => $user,
        ]);

        attempt(fn() => $vacancy->invitations()->createMany($invites->toArray()));
    }
}
