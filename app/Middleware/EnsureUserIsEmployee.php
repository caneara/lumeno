<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserIsEmployee
{
    /**
     * Ensure that the user is an employee.
     *
     */
    public function handle(Request $request, Closure $next)
    {
        abort_unless(user()->isEmployee(), Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
