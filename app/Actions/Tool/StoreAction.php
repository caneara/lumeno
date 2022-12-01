<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;

class StoreAction extends Action
{
    /**
     * Create a new tool using the given payload.
     *
     */
    public static function execute(array $payload) : Tool
    {
        $attributes = array_merge($payload, ['approved' => false]);

        return attempt(fn() => Tool::create($attributes));
    }
}
