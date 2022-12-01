<?php

namespace App\Kernels;

use Throwable;
use App\Responses\Page;
use Inertia\Response as Inertia;
use Illuminate\Http\RedirectResponse;
use App\Exceptions\PageExpiredException;
use App\Exceptions\TooManyRequestsException;
use Illuminate\Foundation\Exceptions\Handler;
use Symfony\Component\HttpFoundation\Response;

class Exception extends Handler
{
    /**
     * Custom HTTP exceptions.
     *
     */
    protected array $exceptions = [
        PageExpiredException::class,
        TooManyRequestsException::class,
    ];

    /**
     * Determine if the response contains a custom HTTP exception.
     *
     */
    protected function isCustomHttpException(Response | RedirectResponse $response) : mixed
    {
        return collect($this->exceptions)
            ->filter(fn($item) => $item::within($response))
            ->first();
    }

    /**
     * Determine whether to render a full, front-end error page.
     *
     */
    protected function shouldRenderErrorPage(int $status) : bool
    {
        $codes = [500, 503, 404, 403];

        $environments = ['local', 'testing'];

        return ! app()->environment($environments) && in_array($status, $codes);
    }

    /**
     * Render an exception into an HTTP response.
     *
     */
    public function render($request, Throwable $e) : Response | Inertia
    {
        $response = parent::render($request, $e);

        if ($exception = $this->isCustomHttpException($response)) {
            return resolve($exception)->render($request);
        }

        if ($this->shouldRenderErrorPage($response->getStatusCode())) {
            return $this->renderErrorPage($request, $response);
        }

        return $response;
    }

    /**
     * Generate the full, front-end error page.
     *
     */
    protected function renderErrorPage($request, Response $response) : Response
    {
        return Page::make()
            ->title('Error')
            ->view('error.index')
            ->with('asset', asset(''))
            ->with('notification', null)
            ->with('code', $response->getStatusCode())
            ->toResponse($request)
            ->setStatusCode($response->getStatusCode());
    }
}
