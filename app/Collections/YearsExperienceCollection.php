<?php

namespace App\Collections;

use App\Types\Collection;

class YearsExperienceCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => 1,  'name' => '1 year (or less)'],
            (object) ['id' => 2,  'name' => '2 years'],
            (object) ['id' => 3,  'name' => '3 years'],
            (object) ['id' => 4,  'name' => '4 years'],
            (object) ['id' => 5,  'name' => '5 years'],
            (object) ['id' => 6,  'name' => '6 years'],
            (object) ['id' => 7,  'name' => '7 years'],
            (object) ['id' => 8,  'name' => '8 years'],
            (object) ['id' => 9,  'name' => '9 years'],
            (object) ['id' => 10, 'name' => '10 years (or more)'],
        ];
    }
}
