<?php

namespace App\Controllers\Authentication;

use App\Models\User;
use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\User\StoreAction;
use App\Actions\Member\EnlistAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Requests\Register\IndexRequest;
use App\Requests\Register\StoreRequest;
use App\Notifications\VerifyEmailAddressNotification;

class RegistrationController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('throttle:5,10')->only('store');
    }

    /**
     * Show the registration page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Register')
            ->view('register.index')
            ->render();
    }

    /**
     * Register a new account.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $user = StoreAction::execute($request->validated(), User::TYPE_CUSTOMER);

        Auth::login($user);

        $user->notify(new VerifyEmailAddressNotification());

        EnlistAction::execute($user, session()->get('enlist'));

        return redirect()->route('email.verify.notice');
    }
}
