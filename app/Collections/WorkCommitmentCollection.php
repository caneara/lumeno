<?php

namespace App\Collections;

use App\Models\Vacancy;
use App\Types\Collection;

class WorkCommitmentCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => Vacancy::COMMITMENT_CONTRACT,  'name' => 'Contract',  'color' => 'blue'],
            (object) ['id' => Vacancy::COMMITMENT_PART_TIME, 'name' => 'Part Time', 'color' => 'orange'],
            (object) ['id' => Vacancy::COMMITMENT_FULL_TIME, 'name' => 'Full Time', 'color' => 'green'],
        ];
    }
}
