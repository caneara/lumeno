<?php

namespace App\Actions\Member;

use App\Models\User;
use App\Types\Action;
use App\Models\Member;
use App\Models\Organization;
use Illuminate\Contracts\Pagination\Paginator;

class ViewAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'members.id',
        'members.role',
        'members.user_id',
        'members.organization_id',
        'users.name',
        'users.email',
        'users.avatar',
    ];

    /**
     * Retrieve the members within the given organization.
     *
     */
    public static function execute(Organization $organization, Member $member, User $user, string $name) : Paginator
    {
        return $organization->members()
            ->join('users', 'members.user_id', '=', 'users.id')
            ->whereLike('users.name', $name)
            ->orderBy('members.role')
            ->orderBy('users.name')
            ->simplePaginate(10, static::$fields)
            ->through(fn($item) => static::format($organization, $member, $user, $item));
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(Organization $organization, Member $member, User $user, Member $item) : Member
    {
        return $item->setAttribute('permissions', [
            'edit'   => $user->can('edit', [Member::class, $member, $organization, $item]),
            'delete' => $user->can('delete', [Member::class, $member, $organization, $item]),
        ]);
    }
}
