<?php

namespace App\Concerns\Shared;

use App\Types\Factory;

trait InteractsWithFactories
{
    /**
     * Create a new factory instance for the model.
     *
     */
    public static function factory($count = null, $state = []) : Factory
    {
        $factory = Factory::factoryForModel(get_called_class());

        return $factory
            ->count(is_numeric($count) ? $count : null)
            ->state(is_callable($count) || is_array($count) ? $count : $state);
    }
}
