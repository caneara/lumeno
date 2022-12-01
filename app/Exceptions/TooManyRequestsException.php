<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TooManyRequestsException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     */
    public function render(Request $request) : RedirectResponse | JsonResponse
    {
        $payload = [
            'message' => 'Too many attempts, please wait a minute',
        ];

        return $request->expectsJson()
            ? response()->json($payload, Response::HTTP_TOO_MANY_REQUESTS)
            : back()->notify($payload['message'], 'error');
    }

    /**
     * Determine if the given response contains the exception.
     *
     */
    public static function within(Response | RedirectResponse | JsonResponse $response) : bool
    {
        return $response->getStatusCode() === Response::HTTP_TOO_MANY_REQUESTS;
    }
}
