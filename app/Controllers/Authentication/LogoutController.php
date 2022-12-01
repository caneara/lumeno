<?php

namespace App\Controllers\Authentication;

use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Authentication\LogoutAction;

class LogoutController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sign the user out of the application.
     *
     */
    public function index() : RedirectResponse
    {
        LogoutAction::execute();

        return redirect()->route('home');
    }
}
