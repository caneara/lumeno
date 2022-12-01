<?php

namespace App\Actions\Project;

use App\Types\Action;
use App\Storage\Image;
use App\Models\Project;

class DeleteAction extends Action
{
    /**
     * Delete the given project.
     *
     */
    public static function execute(Project $project) : void
    {
        Image::delete($project->logo);

        Image::delete($project->first_image);
        Image::delete($project->second_image);
        Image::delete($project->third_image);

        attempt(fn() => $project->delete());
    }
}
