<?php

namespace App\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     */
    protected $except = [
        'stripe/*',
        'paddle/*',
        'spark/webhook',
        'verifai/webhook',
    ];
}
