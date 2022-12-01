<?php

namespace App\Actions\User;

use App\Models\User;
use App\Types\Action;
use App\Models\Member;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class ShowAction extends Action
{
    /**
     * The article fields to retrieve.
     *
     */
    protected static array $articles = [
        'id',
        'user_id',
        'slug',
        'title',
        'summary',
        'first_tag',
        'second_tag',
        'third_tag',
        'fourth_tag',
        'created_at',
    ];

    /**
     * The fields to exclude.
     *
     */
    protected static array $exclude = [
        'area',
        'schools',
        'workplaces',
    ];

    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'id',
        'name',
        'handle',
        'avatar',
        'country',
        'area',
        'time_zone',
        'first_language',
        'second_language',
        'third_language',
        'website',
        'github',
        'twitter',
        'linkedin',
        'discord',
        'youtube',
        'facebook',
        'instagram',
        'statement',
        'skills',
        'schools',
        'projects',
        'articles',
        'workplaces',
        'following',
        'metrics',
        'created_at',
        'updated_at',
    ];

    /**
     * The relationships to retrieve.
     *
     */
    protected static array $relations = [
        'skills' => [
            'id',
            'user_id',
            'tool_id',
            'years',
            'summary',
        ],
        'skills.tool' => [
            'id',
            'category_id',
            'name',
            'approved',
            'originated',
        ],
        'schools' => [
            'id',
            'user_id',
            'qualification',
            'name',
            'course',
            'location',
            'started_at',
            'finished_at',
        ],
        'workplaces' => [
            'id',
            'user_id',
            'employer',
            'location',
            'role',
            'summary',
            'started_at',
            'finished_at',
        ],
        'projects' => [
            'id',
            'user_id',
            'type',
            'logo',
            'title',
            'summary',
            'url',
            'first_tag',
            'second_tag',
            'third_tag',
            'fourth_tag',
            'first_image',
            'second_image',
            'third_image',
        ],
    ];

    /**
     * Generate a professional résumé for the given account.
     *
     */
    public static function execute(User $account, User $user = null, Member $member = null) : Collection
    {
        $account = static::loadRelations($account);

        $account = static::groupRelationsByYear($account);

        $account->articles = static::getPaginatedArticles($account);

        return collect($account->only(static::$fields))
            ->reject(fn($item, $key) => in_array($key, $member ? [] : static::$exclude));
    }

    /**
     * Retrieve a paginated list of the given user's articles.
     *
     */
    protected static function getPaginatedArticles(User $user) : Paginator
    {
        return $user->articles()
            ->orderByDesc('id')
            ->simplePaginate(10, static::$articles);
    }

    /**
     * Sort and group the relevant relations by year.
     *
     */
    protected static function groupRelationsByYear(User $user) : User
    {
        collect(['schools' => null, 'workplaces' => null])
            ->map(fn($item, $key) => $user->getRelation($key)->sortByDesc('started_at'))
            ->map(fn($item) => $item->groupBy(fn($item) => $item->started_at->year))
            ->each(fn($item, $key) => $user->setRelation($key, $item));

        return $user;
    }

    /**
     * Eager load the required relationships for the given account.
     *
     */
    protected static function loadRelations(User $account) : User
    {
        $relations = collect(static::$relations)
            ->map(fn($item, $key) => "{$key}:" . implode(',', $item))
            ->values()
            ->toArray();

        return $account->load($relations);
    }
}
