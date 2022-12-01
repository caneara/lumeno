<?php

namespace App\Concerns\Vacancy;

use App\Models\Vacancy;

trait InteractsWithRequirements
{
    /**
     * Sort the vacancy's requirements by importance.
     *
     */
    public function orderRequirementsByPriority() : Vacancy
    {
        $ordered = $this->requirements
            ->sortBy('optional')
            ->groupBy('optional')
            ->map(fn($group) => $group->sortBy('id'))
            ->flatten();

        return $this->setRelation('requirements', $ordered);
    }
}
