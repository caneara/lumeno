<?php

namespace App\Rules;

use App\Types\Rule;
use Illuminate\Support\Str;

class ForbiddenDomainRule extends Rule
{
    /**
     * The domain names.
     *
     */
    protected array $domains = [
        'caneara.com',
        'lumeno.dev',
        'tipsea.app',
        'laravel.com',
        'laracasts.com',
        'laravel.io',
    ];

    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return "The :attribute was not recognized.";
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $current = $this->parameters[0];

        if (in_array($this->retrieveDomain($current), $this->domains)) {
            return true;
        }

        return ! in_array($this->retrieveDomain($value), $this->domains);
    }

    /**
     * Extract the domain name from the given email address.
     *
     */
    protected function retrieveDomain(string $email) : string
    {
        return Str::lower(explode('@', $email ?: '@')[1]) ?? '';
    }
}
