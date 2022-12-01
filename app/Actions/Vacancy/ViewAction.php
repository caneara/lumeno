<?php

namespace App\Actions\Vacancy;

use App\Models\User;
use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use App\Collections\LanguageCollection;
use Illuminate\Contracts\Pagination\Paginator;

class ViewAction extends Action
{
    /**
     * Retrieve a list of vacancies belonging to the given organization.
     *
     */
    public static function execute(Organization $organization, User $user, string $role) : Paginator
    {
        return $organization->vacancies()
            ->whereLike('role', $role)
            ->orderBy('archived_at')
            ->orderByDesc('id')
            ->simplePaginate(10, static::fields())
            ->through(fn($vacancy) => static::format($organization, $user, $vacancy));
    }

    /**
     * Retrieve the columns to include with the query.
     *
     */
    protected static function fields() : array
    {
        return [
            'id',
            'role',
            'area',
            'country',
            'commitment',
            'months',
            'metrics',
            'currency',
            'remuneration',
            'first_language',
            'second_language',
            'third_language',
            'organization_id',
            'archived_at',
            DB::raw('SUBSTRING(`summary`, 1, 300) AS `summary`'),
        ];
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(Organization $organization, User $user, Vacancy $vacancy) : Vacancy
    {
        $permissions = (object) [
            'edit'    => $user->can('edit', [Vacancy::class, $organization, $vacancy]),
            'delete'  => $user->can('delete', [Vacancy::class, $organization, $vacancy]),
            'export'  => $user->can('export', [Vacancy::class, $organization, $vacancy]),
            'archive' => $user->can('archive', [Vacancy::class, $organization, $vacancy]),
        ];

        return $vacancy
            ->setAttribute('permissions', $permissions)
            ->setAttribute('languages', LanguageCollection::list($vacancy));
    }
}
