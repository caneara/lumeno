<?php

namespace App\Search;

use App\Models\User;
use App\Models\Vacancy;
use App\Search\Sorters\IdSorter;
use Illuminate\Support\Facades\DB;
use App\Search\Filters\AvatarFilter;
use App\Search\Filters\MemberFilter;
use Illuminate\Pagination\Paginator;
use App\Search\Filters\LanguageFilter;
use App\Search\Filters\LocationFilter;
use App\Search\Sorters\DistanceSorter;
use App\Collections\LanguageCollection;
use App\Search\Filters\AvailableFilter;
use App\Search\Filters\CommitmentFilter;
use App\Search\Sorters\EmigrationSorter;
use App\Search\Filters\RequirementFilter;
use App\Search\Sorters\RequirementSorter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use App\Search\Filters\RemunerationFilter;
use App\Search\Filters\QualificationFilter;
use App\Search\Sorters\QualificationSorter;

class Engine
{
    /**
     * The filters to apply.
     *
     */
    protected static array $filters = [
        AvailableFilter::class,
        AvatarFilter::class,
        CommitmentFilter::class,
        QualificationFilter::class,
        LanguageFilter::class,
        LocationFilter::class,
        MemberFilter::class,
        RemunerationFilter::class,
        RequirementFilter::class,
    ];

    /**
     * The sorters to apply.
     *
     */
    protected static array $sorters = [
        EmigrationSorter::class,
        RequirementSorter::class,
        QualificationSorter::class,
        DistanceSorter::class,
        IdSorter::class,
    ];

    /**
     * Determine whether the given user may be contacted about the given vacancy.
     *
     */
    public static function canSendInvitation(User $user, Vacancy $vacancy) : bool
    {
        return ! static::query($vacancy)
            ->where('users.id', $user->id)
            ->value('invitation_id');
    }

    /**
     * Retrieve the columns to include with the query.
     *
     */
    protected static function columns(Vacancy $vacancy) : array
    {
        return [
            'users.id',
            'users.handle',
            'users.area',
            'users.name',
            'users.avatar',
            'users.country',
            'users.time_zone',
            'users.first_language',
            'users.second_language',
            'users.third_language',
            'invitations.id AS invitation_id',
            DB::raw('SUBSTRING(`users`.`statement`, 1, 300) AS `statement`'),
            DB::raw("DISTANCE('{$vacancy->coordinates}', `users`.`coordinates`) AS `distance`"),
        ];
    }

    /**
     * Find the users that are suitable for the given vacancy.
     *
     */
    public static function execute(Vacancy $vacancy) : Paginator
    {
        return static::query($vacancy)
            ->simplePaginate(10, static::columns($vacancy))
            ->through(fn($user) => static::format($user));
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(User $user) : User
    {
        $user->languages = LanguageCollection::list($user);

        return $user;
    }

    /**
     * Determine the appropriate database index to use.
     *
     */
    protected static function index(Vacancy $vacancy) : Expression
    {
        return DB::raw('`users` FORCE INDEX ' . match ($vacancy->commitment) {
            Vacancy::COMMITMENT_FULL_TIME => '(`users_résumé_full_time_index`)',
            Vacancy::COMMITMENT_PART_TIME => '(`users_résumé_part_time_index`)',
            Vacancy::COMMITMENT_CONTRACT  => '(`users_résumé_contract_index`)',
            default                       => '(`users_résumé_full_time_index`)',
        });
    }

    /**
     * Include the invitation status for each user in the given query.
     *
     */
    protected static function invitations(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->leftJoin('invitations', function($join) use ($vacancy) {
            return $join->on('users.id', '=', 'invitations.user_id')
                ->where('vacancy_id', $vacancy->id);
        });
    }

    /**
     * Construct the database query and retrieve its results.
     *
     */
    public static function query(Vacancy $vacancy) : Builder
    {
        $vacancy = static::requirements($vacancy);

        $query = User::query()
            ->from(static::index($vacancy))
            ->select(static::columns($vacancy))
            ->where('users.type', User::TYPE_CUSTOMER)
            ->tap(fn($query) => static::invitations($query, $vacancy));

        foreach (array_merge(static::$filters, static::$sorters) as $step) {
            $query = $step::execute($vacancy, $query);
        }

        return $query;
    }

    /**
     * Retrieve and sort the given vacancy's requirements.
     *
     */
    protected static function requirements(Vacancy $vacancy) : Vacancy
    {
        if (! $vacancy->relationLoaded('requirements')) {
            $vacancy->load('requirements');
        }

        $vacancy->requirements = $vacancy->requirements->sortBy('id')->values();

        return $vacancy;
    }
}
