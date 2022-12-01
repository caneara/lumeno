<?php

namespace Tests\Workshops;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Models\Member;
use App\Models\School;
use App\Models\Vacancy;
use App\Models\Requirement;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use App\Collections\CurrencyCollection;

class VacancyWorkshop
{
    /**
     * Seed the database with the relevant testing data.
     *
     */
    public static function build() : object
    {
        static::currencies();

        return (object) [
            'tool'         => Tool::factory()->create(),
            'organization' => $organization = Organization::factory()->hasSubscription('Silver')->create(),
            'subscription' => $organization->subscription(),
            'vacancy'      => static::vacancy(),
            'user_1'       => static::user(),
            'user_2'       => User::factory()->create(['statement' => Str::random(50)]),
            'résumé'       => static::resume(),
        ];
    }

    /**
     * Seed the currencies.
     *
     */
    protected static function currencies() : void
    {
        CurrencyCollection::seed();

        DB::table('currencies')
            ->where('id', 1)
            ->update(['rate' => 1]);
    }

    /**
     * Seed the résumé.
     *
     */
    public static function resume(User $user = null) : void
    {
        if (blank($user)) {
            Member::factory()
                ->belongsTo(Organization::first(), User::second())
                ->create();
        }

        School::factory()
            ->belongsTo($user ?: User::first())
            ->create(['qualification' => School::QUALIFICATION_ASSOCIATE_DEGREE]);

        Skill::factory()
            ->belongsTo($user ?: User::first(), Tool::first())
            ->create(['years' => 1]);
    }

    /**
     * Seed the user.
     *
     */
    public static function user() : User
    {
        return User::factory()->create([
            'full_time'       => true,
            'part_time'       => true,
            'contract'        => true,
            'currency'        => 1,
            'remuneration'    => 1500,
            'country'         => 1,
            'commute'         => 75,
            'coordinates'     => '39.38, -77.40',
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => 3,
            'remote'          => User::REMOTE_YES,
            'emigrate'        => true,
            'statement'       => Str::random(50),
        ]);
    }

    /**
     * Seed the vacancy.
     *
     */
    protected static function vacancy() : Vacancy
    {
        return Vacancy::factory()
            ->belongsTo(Organization::first())
            ->with(Requirement::class, [Organization::first(), Tool::first()], [
                'years'    => 1,
                'optional' => false,
            ])
            ->create([
                'summary'         => Str::random(50),
                'commitment'      => Vacancy::COMMITMENT_FULL_TIME,
                'months'          => null,
                'currency'        => 1,
                'remuneration'    => 2000,
                'country'         => 1,
                'coordinates'     => '38.89, -77.03',
                'first_language'  => 1,
                'second_language' => 2,
                'third_language'  => 3,
                'remote'          => false,
                'emigrate'        => false,
                'degree'          => true,
            ]);
    }
}
