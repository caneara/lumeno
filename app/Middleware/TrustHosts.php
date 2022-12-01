<?php

namespace App\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Retrieve the host patterns that should be trusted.
     *
     */
    public function hosts() : array
    {
        return [$this->allSubdomainsOfApplicationUrl()];
    }
}
