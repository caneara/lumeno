<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;
use Illuminate\Support\Str;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Collections\RemoteWorkingCollection;
use App\Collections\CommuteDistanceCollection;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        $latitude  = (rand(0, 1) ? '-' : '') . rand(10, 80) . '.' . rand(10, 99);
        $longitude = (rand(0, 1) ? '-' : '') . rand(10, 170) . '.' . rand(10, 99);

        return [
            'type'              => User::TYPE_CUSTOMER,
            'name'              => fake()->name(),
            'handle'            => fake()->unique()->userName(),
            'email'             => fake()->unique()->email(),
            'password'          => 'Q5p@4xFvw9w#',
            'avatar'            => uuid(),
            'available'         => true,
            'country'           => CountryCollection::make()->random()->id,
            'area'              => fake()->city() . ', ' . fake()->state(),
            'coordinates'       => "{$latitude},{$longitude}",
            'time_zone'         => TimeZoneCollection::make()->random()->id,
            'full_time'         => fake()->boolean(),
            'part_time'         => fake()->boolean(),
            'contract'          => fake()->boolean(),
            'first_language'    => LanguageCollection::make()->random()->id,
            'second_language'   => LanguageCollection::make()->random()->id,
            'third_language'    => LanguageCollection::make()->random()->id,
            'emigrate'          => fake()->boolean(),
            'remote'            => $remote = RemoteWorkingCollection::make()->random()->id,
            'commute'           => $remote === User::REMOTE_NO ? 0 : CommuteDistanceCollection::make()->random()->id,
            'currency'          => CurrencyCollection::make()->random()->id,
            'remuneration'      => rand(20000, 1000000),
            'website'           => 'https://' . fake()->domainName(),
            'github'            => Str::random(15),
            'twitter'           => Str::random(15),
            'linkedin'          => Str::random(15),
            'discord'           => Str::random(15),
            'youtube'           => Str::random(15),
            'facebook'          => Str::random(15),
            'instagram'         => Str::random(15),
            'statement'         => fake()->text(200) . "\n\n" . fake()->text(200) . "\n\n" . fake()->text(200),
            'remember_token'    => Str::random(10),
            'email_verified_at' => now(),
        ];
    }

    /**
     * Ensure that the user is an employee.
     *
     */
    public function employee() : static
    {
        return $this->state(fn() => ['type' => User::TYPE_EMPLOYEE]);
    }
}
