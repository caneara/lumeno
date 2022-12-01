<?php

namespace App\Collections;

use App\Models\User;
use App\Types\Collection;

class RemoteWorkingCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => User::REMOTE_NO,   'name' => 'I will not work remotely'],
            (object) ['id' => User::REMOTE_YES,  'name' => 'I will work remotely'],
            (object) ['id' => User::REMOTE_ONLY, 'name' => 'I will only work remotely'],
        ];
    }
}
