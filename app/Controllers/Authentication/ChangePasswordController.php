<?php

namespace App\Controllers\Authentication;

use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Password\ChangeAction;
use App\Requests\Password\ChangeRequest;

class ChangePasswordController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Change the user's password.
     *
     */
    public function update(ChangeRequest $request) : RedirectResponse
    {
        ChangeAction::execute(user(), $request->new_password);

        return redirect()
            ->route('account.edit')
            ->notify('Your password has been updated');
    }
}
