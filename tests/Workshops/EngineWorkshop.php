<?php

namespace Tests\Workshops;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Models\Member;
use App\Models\School;
use App\Models\Vacancy;
use App\Models\Category;
use App\Models\Requirement;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use App\Collections\CurrencyCollection;
use Illuminate\Database\Eloquent\Factories\Sequence;

class EngineWorkshop
{
    /**
     * Seed the database with the relevant testing data.
     *
     */
    public static function build() : object
    {
        static::tools();
        static::users();
        static::members();
        static::vacancy();
        static::resumes();
        static::currencies();

        return (object) [
            'organization' => Organization::first(),
            'vacancy'      => Vacancy::first(),
            'user'         => User::first(),
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
     * Seed the members.
     *
     */
    protected static function members() : void
    {
        Organization::factory()
            ->with(Member::class, User::second())
            ->create();

        Organization::factory()
            ->with(Member::class, User::first())
            ->create();
    }

    /**
     * Seed the résumés.
     *
     */
    protected static function resumes() : void
    {
        School::factory()
            ->belongsTo(User::first())
            ->create(['qualification' => School::QUALIFICATION_ASSOCIATE_DEGREE]);

        School::factory()
            ->belongsTo(User::second())
            ->create(['qualification' => School::QUALIFICATION_STUDYING]);

        School::factory()
            ->belongsTo(User::third())
            ->create(['qualification' => School::QUALIFICATION_CERTIFICATE]);

        Skill::factory()
            ->belongsTo(User::first(), Tool::first())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo(User::first(), Tool::second())
            ->create(['years' => 2]);

        Skill::factory()
            ->belongsTo(User::first(), Tool::third())
            ->create(['years' => 3]);

        Skill::factory()
            ->belongsTo(User::second(), Tool::first())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo(User::second(), Tool::second())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo(User::second(), Tool::third())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo(User::third(), Tool::first())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo(User::third(), Tool::second())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo(User::third(), Tool::third())
            ->create(['years' => 5]);
    }

    /**
     * Seed the tools.
     *
     */
    protected static function tools() : void
    {
        Category::factory()
            ->hasTools(3)
            ->create();
    }

    /**
     * Seed the users.
     *
     */
    protected static function users() : void
    {
        User::factory()->create([
            'full_time'       => true,
            'part_time'       => true,
            'contract'        => true,
            'currency'        => 1,
            'remuneration'    => 1500,
            'country'         => 1,
            'commute'         => 75,
            'coordinates'     => '38.89, -77.03',
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => 3,
            'remote'          => User::REMOTE_YES,
            'emigrate'        => true,
        ]);

        User::factory()->create([
            'full_time'       => false,
            'part_time'       => false,
            'contract'        => false,
            'currency'        => 1,
            'remuneration'    => 2500,
            'country'         => 1,
            'commute'         => 100,
            'coordinates'     => '39.41, -77.41',
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => 3,
            'remote'          => User::REMOTE_NO,
            'emigrate'        => false,
        ]);

        User::factory()->create([
            'avatar'          => null,
            'available'       => false,
            'full_time'       => false,
            'part_time'       => false,
            'contract'        => false,
            'currency'        => 1,
            'remuneration'    => 3500,
            'country'         => 1,
            'commute'         => 50,
            'coordinates'     => '39.41, -77.41',
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => 3,
            'remote'          => User::REMOTE_ONLY,
            'emigrate'        => false,
        ]);
    }

    /**
     * Seed the vacancy.
     *
     */
    protected static function vacancy() : void
    {
        $sequence = new Sequence([
            'tool_id'  => Tool::first(),
            'years'    => 1,
            'optional' => false,
        ], [
            'tool_id'  => Tool::second(),
            'years'    => 2,
            'optional' => false,
        ], [
            'tool_id'  => Tool::third(),
            'years'    => 3,
            'optional' => true,
        ]);

        Vacancy::factory()
            ->belongsTo(Organization::first())
            ->with(3, Requirement::class, [], $sequence)
            ->create([
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
