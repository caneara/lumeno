<?php

namespace App\Controllers\Authentication;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Requests\Email\VerifyRequest;
use Illuminate\Http\RedirectResponse;
use App\Notifications\VerifyEmailAddressNotification;

class VerifyEmailController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('update');
        $this->middleware('throttle:6,1')->only('update');
        $this->middleware('throttle:1,10')->only('store');
    }

    /**
     * Show the email verification page.
     *
     */
    public function index() : Response | RedirectResponse
    {
        if (user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard.user');
        }

        return Page::make()
            ->title('Verify Email')
            ->view('email.index')
            ->render();
    }

    /**
     * Send the verification email.
     *
     */
    public function store() : RedirectResponse
    {
        if (user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard.user');
        }

        user()->notify(new VerifyEmailAddressNotification());

        return redirect()
            ->route('email.verify.notice')
            ->notify('A link has been sent to your email');
    }

    /**
     * Mark the user's email address as verified.
     *
     */
    public function update(VerifyRequest $request) : RedirectResponse
    {
        if (! user()->hasVerifiedEmail()) {
            attempt(fn() => user()->markEmailAsVerified());
        }

        return redirect()->route('dashboard.user');
    }
}
