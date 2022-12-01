<?php

namespace Database\Factories;

use App\Types\Factory;
use App\Models\Vacancy;
use Illuminate\Support\Arr;
use App\Models\Organization;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\WorkCommitmentCollection;

class VacancyFactory extends Factory
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
            'organization_id' => Organization::factory(),
            'role'            => fake()->jobTitle(),
            'summary'         => fake()->text(300),
            'commitment'      => $type = WorkCommitmentCollection::make()->random()->id,
            'months'          => $type === Vacancy::COMMITMENT_CONTRACT ? rand(1, 11) : null,
            'currency'        => CurrencyCollection::make()->random()->id,
            'remuneration'    => rand(20000, 100000),
            'area'            => fake()->city() . ', ' . fake()->state(),
            'country'         => CountryCollection::make()->random()->id,
            'coordinates'     => "{$latitude},{$longitude}",
            'first_language'  => LanguageCollection::make()->random()->id,
            'second_language' => LanguageCollection::make()->random()->id,
            'third_language'  => LanguageCollection::make()->random()->id,
            'remote'          => fake()->boolean(),
            'emigrate'        => fake()->boolean(),
            'degree'          => fake()->boolean(),
            'email'           => fake()->unique()->email(),
            'phone'           => $this->randomPhoneNumber(),
            'website'         => 'https://' . fake()->domainName(),
            'archived_at'     => null,
        ];
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
