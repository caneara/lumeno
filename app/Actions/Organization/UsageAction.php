<?php

namespace App\Actions\Organization;

use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Organization;
use App\Models\Subscription;

class UsageAction extends Action
{
    /**
     * Charge the given organization for usage.
     *
     */
    public static function execute(Organization $organization, Vacancy $vacancy, int $total) : void
    {
        $subscription = $organization->subscription();

        $price = sprintf('%0.2f', static::price($subscription, $total));

        $subscription->newModifier($price)
            ->description("Vacancy #{$vacancy->id}")
            ->oneTime()
            ->create();
    }

    /**
     * Retrieve the amount to charge the given subscription for usage.
     *
     */
    protected static function price(Subscription $subscription, int $total) : float
    {
        $plan = $subscription->paddle_plan;

        return collect(config('spark.billables.organization.plans'))
            ->filter(fn($item) => in_array($plan, [$item['monthly_id'] ?? '', $item['yearly_id'] ?? '']))
            ->first()['prices']['usage'] * $total;
    }
}
