<?php

namespace App\Controllers\Authentication;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Authentication\LoginAction;
use App\Requests\Authentication\LoginRequest;

class LoginController extends Controller
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
     * Show the login page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Login')
            ->view('login.index')
            ->render();
    }

    /**
     * Sign the user into the application.
     *
     */
    public function store(LoginRequest $request) : RedirectResponse
    {
        LoginAction::execute($request->validated());

        return redirect()->intended(route('dashboard.user'));
    }
}
