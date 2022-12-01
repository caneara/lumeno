<?php

namespace App\Collections;

use App\Types\Collection;

class ToolCategoryCollection extends Collection
{
    /**
     * The database table associated with the collection.
     *
     */
    protected static string $table = 'categories';

    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) [
                'id'   => '95aaff42-1d58-4f0d-828b-f83e581f5409',
                'name' => 'Programming Languages',
            ],
            (object) [
                'id'   => '95aaff42-38ea-4930-b29f-62d6b186b8e2',
                'name' => 'Language Frameworks / Environments',
            ],
            (object) [
                'id'   => '95ffc2bc-cd89-422f-852d-12fed40bddf9',
                'name' => 'Hardware, Networking or Architecture',
            ],
            (object) [
                'id'   => '95aaff42-19e2-4b15-ab49-c02617481d05',
                'name' => 'Operating Systems',
            ],
            (object) [
                'id'   => '95aaff42-3297-4167-ba6d-ae0cbfb60199',
                'name' => 'Database Systems',
            ],
            (object) [
                'id'   => '95b8e3f5-2cd3-4a30-ad17-99b06e81cc94',
                'name' => 'Design, Graphics or Prototyping',
            ],
            (object) [
                'id'   => '95aaff42-36f5-439e-9884-db3f662ae26c',
                'name' => 'DevOps / Server Management',
            ],
            (object) [
                'id'   => '95aaff42-2892-44d4-b6e5-6c5448dcf44e',
                'name' => 'Support, Testing or Quality Assurance',
            ],
            (object) [
                'id'   => '95aaff42-2dc2-4dbe-a6e5-338ec12b554f',
                'name' => 'IDEs, Compilers, Bundlers or Utilities',
            ],
            (object) [
                'id'   => '95aaff42-33f0-42c6-911f-52f63ea21b38',
                'name' => 'Other',
            ],
        ];
    }
}
