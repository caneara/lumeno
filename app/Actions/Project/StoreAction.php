<?php

namespace App\Actions\Project;

use App\Models\User;
use App\Types\Action;
use App\Models\Project;
use Illuminate\Support\Arr;
use App\Actions\Image\UpdateAction as ImageAction;

class StoreAction extends Action
{
    /**
     * Create a new project using the given user and payload.
     *
     */
    public static function execute(User $user, array $payload) : Project
    {
        $attributes = Arr::except($payload, 'logo');

        $project = attempt(fn() => $user->projects()->create($attributes));

        ImageAction::execute($project, 'logo', $payload['logo'] ?? null);

        return $project;
    }
}
