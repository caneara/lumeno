<?php

namespace App\Actions\Requirement;

use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Requirement;
use Illuminate\Support\Collection;

class ViewAction extends Action
{
    /**
     * Retrieve the given vacancy's requirements.
     *
     */
    public static function execute(Vacancy $vacancy) : Collection
    {
        return $vacancy
            ->requirements()
            ->with('tool.category')
            ->get()
            ->sortBy('id')
            ->map(fn($item) => static::format($item));
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(Requirement $requirement) : array
    {
        return [
            'id'         => $requirement->id,
            'tool_id'    => $requirement->tool_id,
            'tool_name'  => $requirement->tool->name,
            'originated' => $requirement->tool->originated,
            'category'   => $requirement->tool->category->name,
            'optional'   => $requirement->optional,
            'years'      => $requirement->years,
            'summary'    => $requirement->summary,
        ];
    }
}
