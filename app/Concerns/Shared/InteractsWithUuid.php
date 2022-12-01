<?php

namespace App\Concerns\Shared;

trait InteractsWithUuid
{
    /**
     * Bootstrap the trait.
     *
     */
    public static function bootInteractsWithUuid() : void
    {
        static::creating(function($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = uuid();
            }
        });
    }

    /**
     * Determine whether the model should use auto-incrementation.
     *
     */
    public function getIncrementing() : bool
    {
        return false;
    }

    /**
     * Determine the data type of the model's primary key.
     *
     */
    public function getKeyType() : string
    {
        return 'string';
    }
}
