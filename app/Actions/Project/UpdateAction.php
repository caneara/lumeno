<?php

namespace App\Actions\Project;

use App\Types\Action;
use App\Storage\Image;
use App\Models\Project;
use Illuminate\Support\Arr;
use App\Actions\Image\UpdateAction as ImageAction;

class UpdateAction extends Action
{
    /**
     * Update the given project using the given payload.
     *
     */
    public static function execute(Project $project, array $payload) : Project
    {
        static::removeOldImages($project, $payload);

        ImageAction::execute($project, 'logo', $payload['logo'] ?? null);

        return attempt(fn() => tap($project)->update(Arr::except($payload, 'logo')));
    }

    /**
     * Purge any old images that are no longer required.
     *
     */
    protected static function removeOldImages(Project $project, array $payload) : void
    {
        collect(['first_image', 'second_image', 'third_image'])
            ->reject(fn($item) => $project[$item] === $payload[$item])
            ->each(fn($item)   => Image::delete($project[$item]));
    }
}
