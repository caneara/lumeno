<?php

namespace App\Controllers\Authentication;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Http\Request;
use App\Actions\Password\ResetAction;
use Illuminate\Http\RedirectResponse;
use App\Requests\Password\ResetRequest;

class ResetPasswordController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the reset password page.
     *
     */
    public function index(Request $request, string $token = '') : Response
    {
        return Page::make()
            ->title('Reset Password')
            ->view('password.reset')
            ->with('token', $token)
            ->with('email', $request->email);
    }

    /**
     * Reset the given user's password.
     *
     */
    public function store(ResetRequest $request) : RedirectResponse
    {
        ResetAction::execute($request->validated());

        return redirect()
            ->route('dashboard.user')
            ->notify('Your password has been updated');
    }
}
