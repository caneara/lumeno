<?php

namespace App\Collections;

use App\Models\User;
use App\Types\Collection;

class CommuteDistanceCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => User::COMMUTE_KILOMETERS_ZERO, 'hidden' => true,  'name' => 'None (Remote Working)'],
            (object) ['id' => User::COMMUTE_KILOMETERS_5,    'hidden' => false, 'name' => '5 kilometers / 3 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_10,   'hidden' => false, 'name' => '10 kilometers / 6 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_15,   'hidden' => false, 'name' => '15 kilometers / 9 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_20,   'hidden' => false, 'name' => '20 kilometers / 12 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_25,   'hidden' => false, 'name' => '25 kilometers / 15 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_30,   'hidden' => false, 'name' => '30 kilometers / 18 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_40,   'hidden' => false, 'name' => '40 kilometers / 24 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_50,   'hidden' => false, 'name' => '50 kilometers / 30 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_75,   'hidden' => false, 'name' => '75 kilometers / 46 miles'],
            (object) ['id' => User::COMMUTE_KILOMETERS_100,  'hidden' => false, 'name' => '100 kilometers / 62 miles'],
        ];
    }
}
