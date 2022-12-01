<?php

namespace App\Controllers\Authentication;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Password\ForgotAction;
use App\Requests\Password\ForgotRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->middleware('throttle:3,10')->only('store');
    }

    /**
     * Show the forgot password page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Forgot Password')
            ->view('password.forgot')
            ->render();
    }

    /**
     * Send a reset link to the user with the given email address.
     *
     */
    public function store(ForgotRequest $request) : RedirectResponse
    {
        ForgotAction::execute(['email' => $request->email]);

        return redirect()
            ->route('password.forgot')
            ->notify('A password reset link has been sent');
    }
}
