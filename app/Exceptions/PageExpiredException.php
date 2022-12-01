<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PageExpiredException extends Exception
{
    /**
     * The HTTP status code to use.
     *
     */
    public const HTTP_STATUS_CODE = 419;

    /**
     * Render the exception into an HTTP response.
     *
     */
    public function render(Request $request) : RedirectResponse | JsonResponse
    {
        $payload = [
            'message' => 'The page expired, please try again',
        ];

        return $request->expectsJson()
            ? response()->json($payload, static::HTTP_STATUS_CODE)
            : back()->notify($payload['message'], 'error');
    }

    /**
     * Determine if the given response contains the exception.
     *
     */
    public static function within(Response | RedirectResponse | JsonResponse $response) : bool
    {
        return $response->getStatusCode() === static::HTTP_STATUS_CODE;
    }
}
