<?php

namespace App\Actions\Organization;

use App\Types\Action;
use App\Models\Organization;
use App\Models\Subscription;

class DeleteAction extends Action
{
    /**
     * Delete the given organization.
     *
     */
    public static function execute(Organization $organization) : void
    {
        if ($organization->subscribed()) {
            attempt(fn() => $organization->subscription()->cancelNow());
        }

        $subscriptions = Subscription::query()
            ->where('billable_id', $organization->id)
            ->where('billable_type', Organization::class);

        attempt(fn() => $subscriptions->delete());

        attempt(fn() => $organization->delete());
    }
}
