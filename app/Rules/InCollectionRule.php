<?php

namespace App\Rules;

use App\Types\Rule;

class InCollectionRule extends Rule
{
    /**
     * Flag for whether the input is an array.
     *
     */
    protected bool $many = false;

    /**
     * Defer to the underlying collection.
     *
     */
    public function __call(string $method, array $parameters = []) : static
    {
        $this->parameters[0] = $this->parameters[0]->{$method}(...$parameters);

        return $this;
    }

    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        $text = $this->many ? 'items are' : 'item is';

        return "The selected {$text} not valid.";
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        if (is_array($value)) {
            $this->many = true;
        }

        return collect((array) $value)->every(function($value) {
            return $this->parameters[0]->contains($this->parameters[1], $value);
        });
    }
}
