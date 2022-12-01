<?php

namespace Database\Factories;

use App\Types\Factory;
use Illuminate\Support\Arr;
use App\Models\Organization;
use App\Models\Subscription;

class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'name'    => fake()->company(),
            'email'   => fake()->unique()->email(),
            'phone'   => $this->randomPhoneNumber(),
            'website' => 'https://' . fake()->domainName(),
        ];
    }

    /**
     * Assign a subscription to the organization.
     *
     */
    public function hasSubscription(string $plan = '', string $status = '') : static
    {
        $plan = $plan ? $plan : 'Platinum';

        $status = $status ? $status : Subscription::STATUS_ACTIVE;

        return $this->afterCreating(function($organization) use ($plan, $status) {
            $this->makeSubscription($organization, $plan, $status);
        });
    }

    /**
     * Generate a new subscription for the given organization.
     *
     */
    protected function makeSubscription(Organization $organization, string $plan, string $status) : void
    {
        $plans = config('spark.billables.organization.plans');

        $organization->customer->update([
            'trial_ends_at' => null,
        ]);

        $payload = [
            'billable_type' => Organization::class,
            'paddle_status' => $status,
            'paddle_plan'   => collect($plans)->firstWhere('name', "{$plan} Plan")['monthly_id'],
        ];

        Subscription::factory()
            ->belongsTo($organization)
            ->create($payload);
    }

    /**
     * Retrieve a random, but valid phone number.
     *
     */
    protected function randomPhoneNumber() : string
    {
        return Arr::random([
            '+12069536978',
            '+13028299743',
            '+12104978372',
            '+13052816567',
            '+447158656473',
            '+447777600498',
            '+447457500615',
            '+447494895188',
            '+353822201581',
            '+353834237798',
            '+353889105586',
            '+353822217084',
        ]);
    }
}
