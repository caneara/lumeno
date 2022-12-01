<?php

namespace App\Rules;

use App\Types\Rule;
use App\Models\Tool;

class MaxYearsExperienceRule extends Rule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return 'The tool has not existed for that long.';
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $max = Tool::query()
            ->where('id', $this->parameters[0])
            ->value('originated');

        $age = (now()->year - $max) === 0 ? 1 : now()->year - $max;

        return $value <= $age;
    }
}
