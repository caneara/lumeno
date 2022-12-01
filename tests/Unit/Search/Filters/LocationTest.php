<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\LocationFilter;

class LocationTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter_for_national_office_workers() : void
    {
        $vacancy = Vacancy::factory()->create([
            'country'     => 1,
            'remote'      => false,
            'emigrate'    => false,
            'coordinates' => '51.50, -0.07',
        ]);

        $user_1 = User::factory()->create([
            'country'     => 1,
            'remote'      => User::REMOTE_NO,
            'commute'     => 25,
            'coordinates' => '51.70, -0.02', // 21.6 KM
        ]);

        $user_2 = User::factory()->create([
            'country'     => 1,
            'remote'      => User::REMOTE_YES,
            'commute'     => 25,
            'coordinates' => '51.76, 0.09', // 31.1 KM
        ]);

        $user_3 = User::factory()->create([
            'country'     => 1,
            'remote'      => User::REMOTE_ONLY,
            'commute'     => 75,
            'coordinates' => '39.38, -77.40', // 63.28 KM
        ]);

        $user_4 = User::factory()->create([
            'country'     => 2,
            'remote'      => User::REMOTE_NO,
            'commute'     => 25,
            'coordinates' => '51.70, -0.02', // 21.6 KM
        ]);

        $user_5 = User::factory()->create([
            'country'     => 2,
            'remote'      => User::REMOTE_YES,
            'commute'     => 25,
            'coordinates' => '51.76, 0.09', // 31.1 KM
        ]);

        $user_6 = User::factory()->create([
            'country'     => 2,
            'remote'      => User::REMOTE_ONLY,
            'commute'     => 75,
            'coordinates' => '39.38, -77.40', // 63.28 KM
        ]);

        $results = LocationFilter::execute($vacancy, User::query())->get();

        $this->assertCount(1, $results);

        $this->assertTrue($results[0]->is($user_1));
    }

    /** @test */
    public function it_can_perform_a_filter_for_national_remote_workers() : void
    {
        $vacancy = Vacancy::factory()->create([
            'country'  => 1,
            'remote'   => true,
            'emigrate' => false,
        ]);

        $user_1 = User::factory()->create([
            'country' => 1,
            'remote'  => User::REMOTE_NO,
        ]);

        $user_2 = User::factory()->create([
            'country' => 1,
            'remote'  => User::REMOTE_YES,
        ]);

        $user_3 = User::factory()->create([
            'country' => 1,
            'remote'  => User::REMOTE_ONLY,
        ]);

        $user_4 = User::factory()->create([
            'country' => 2,
            'remote'  => User::REMOTE_NO,
        ]);

        $user_5 = User::factory()->create([
            'country' => 2,
            'remote'  => User::REMOTE_YES,
        ]);

        $user_6 = User::factory()->create([
            'country' => 2,
            'remote'  => User::REMOTE_ONLY,
        ]);

        $results = LocationFilter::execute($vacancy, User::query())->get();

        $this->assertCount(2, $results);

        $this->assertTrue($results[0]->is($user_2));
        $this->assertTrue($results[1]->is($user_3));
    }

    /** @test */
    public function it_can_perform_a_filter_for_international_office_workers() : void
    {
        $vacancy = Vacancy::factory()->create([
            'country'     => 1,
            'remote'      => false,
            'emigrate'    => true,
            'coordinates' => '51.50, -0.07',
        ]);

        $user_1 = User::factory()->create([
            'emigrate'    => true,
            'country'     => 1,
            'remote'      => User::REMOTE_NO,
            'commute'     => 25,
            'coordinates' => '51.70, -0.02', // 21.6 KM
        ]);

        $user_2 = User::factory()->create([
            'emigrate'    => false,
            'country'     => 1,
            'remote'      => User::REMOTE_YES,
            'commute'     => 25,
            'coordinates' => '51.76, 0.09', // 31.1 KM
        ]);

        $user_3 = User::factory()->create([
            'emigrate'    => true,
            'country'     => 1,
            'remote'      => User::REMOTE_ONLY,
            'commute'     => 75,
            'coordinates' => '39.38, -77.40', // 63.28 KM
        ]);

        $user_4 = User::factory()->create([
            'emigrate'    => true,
            'country'     => 2,
            'remote'      => User::REMOTE_NO,
            'commute'     => 25,
            'coordinates' => '51.70, -0.02', // 21.6 KM
        ]);

        $user_5 = User::factory()->create([
            'emigrate'    => false,
            'country'     => 2,
            'remote'      => User::REMOTE_YES,
            'commute'     => 25,
            'coordinates' => '51.76, 0.09', // 31.1 KM
        ]);

        $user_6 = User::factory()->create([
            'emigrate'    => true,
            'country'     => 2,
            'remote'      => User::REMOTE_ONLY,
            'commute'     => 75,
            'coordinates' => '39.38, -77.40', // 63.28 KM
        ]);

        $results = LocationFilter::execute($vacancy, User::query())->get();

        $this->assertCount(2, $results);

        $this->assertTrue($results[0]->is($user_1));
        $this->assertTrue($results[1]->is($user_4));
    }

    /** @test */
    public function it_can_perform_a_filter_for_international_remote_workers() : void
    {
        $vacancy = Vacancy::factory()->create([
            'remote'   => true,
            'emigrate' => true,
        ]);

        $user_1 = User::factory()->create([
            'remote' => User::REMOTE_NO,
        ]);

        $user_2 = User::factory()->create([
            'remote' => User::REMOTE_YES,
        ]);

        $user_3 = User::factory()->create([
            'remote' => User::REMOTE_ONLY,
        ]);

        $results = LocationFilter::execute($vacancy, User::query())->get();

        $this->assertCount(2, $results);

        $this->assertTrue($results[0]->is($user_2));
        $this->assertTrue($results[1]->is($user_3));
    }
}
