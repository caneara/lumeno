<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AccessDeniedException extends Exception
{
    /**
     * Determine if the application is the referer.
     *
     */
    public function appIsReferer(Request $request) : bool
    {
        $referer = $request->header('referer') ?? '';

        $host   = Arr::get(parse_url($referer), 'host', '');
        $scheme = Arr::get(parse_url($referer), 'scheme', '');

        return "{$scheme}://{$host}" === config('app.url');
    }

    /**
     * Render the exception into an HTTP response.
     *
     */
    public function render(Request $request) : RedirectResponse | JsonResponse
    {
        $error = $this->getMessage();

        if ($request->expectsJson()) {
            return response()->json($error, Response::HTTP_FORBIDDEN);
        }

        return $this->appIsReferer($request)
            ? back()->notify($error, 'error')
            : redirect()->route('home')->notify($error, 'error');
    }
}
