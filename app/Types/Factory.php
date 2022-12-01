<?php

namespace App\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory as BaseFactory;

abstract class Factory extends BaseFactory
{
    /**
     * Associate the given models with the factory.
     *
     */
    public function belongsTo(...$models) : static
    {
        $factory = $this;

        foreach ($models as $model) {
            if (is_array($model)) {
                $factory = $factory->for($model[0], $model[1] ?? null);
            } else {
                $factory = $factory->for($model);
            }
        }

        return $factory;
    }

    /**
     * Create a collection of models and persist them to the database.
     *
     */
    public function create($attributes = [], ?Model $parent = null) : mixed
    {
        return parent::create($attributes, $parent);
    }

    /**
     * Create related models and associate them with the factory.
     *
     */
    public function with(int | string $count, mixed $model = null, mixed $relations = null, mixed $attributes = null) : static
    {
        if (is_string($count)) {
            $attributes = $relations;
            $relations  = $model;
            $model      = $count;
            $count      = 1;
        }

        $factory = $model::factory($count);

        if (filled($relations)) {
            $relations = is_array($relations) ? $relations : [$relations];

            $factory = $factory->belongsTo(...$relations);
        }

        return $this->has(blank($attributes) ? $factory : $factory->state($attributes));
    }
}
