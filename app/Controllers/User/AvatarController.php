<?php

namespace App\Controllers\User;

use App\Types\Controller;
use App\Actions\User\UpdateAction;
use Illuminate\Http\RedirectResponse;
use App\Requests\Avatar\UpdateRequest;

class AvatarController extends Controller
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
     * Update the current user's avatar.
     *
     */
    public function update(UpdateRequest $request) : RedirectResponse
    {
        UpdateAction::execute(user(), $request->validated());

        return redirect()
            ->route('account.edit')
            ->notify('Your account has been updated');
    }
}
