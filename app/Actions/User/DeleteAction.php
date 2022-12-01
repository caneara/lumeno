<?php

namespace App\Actions\User;

use App\Models\User;
use App\Types\Action;
use App\Storage\Image;
use App\Actions\Authentication\LogoutAction;
use App\Actions\Article\DeleteAction as DeleteArticleAction;
use App\Actions\Project\DeleteAction as DeleteProjectAction;
use App\Actions\Organization\DeleteAction as DeleteOrganizationAction;

class DeleteAction extends Action
{
    /**
     * Delete the given user.
     *
     */
    public static function execute(User $user) : void
    {
        static::removeEmptyOrganization($user);

        Image::delete($user->avatar);

        LogoutAction::execute();

        $user->projects->each(fn($project) => DeleteProjectAction::execute($project));

        $user->articles->each(fn($article) => DeleteArticleAction::execute($article));

        attempt(fn() => $user->delete());
    }

    /**
     * Delete the given user's organization if they are the only member.
     *
     */
    protected static function removeEmptyOrganization(User $user) : void
    {
        $organization = $user?->member?->organization;

        if ($organization && $organization->metrics->member_count === 1) {
            DeleteOrganizationAction::execute($organization);
        }
    }
}
