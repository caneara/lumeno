<?php

namespace App\Controllers\User;

use App\Models\User;
use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\User\ShowAction;
use App\Actions\User\DeleteAction;
use App\Actions\User\UpdateAction;
use App\Requests\Account\EditRequest;
use Illuminate\Http\RedirectResponse;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Requests\Account\DeleteRequest;
use App\Requests\Account\UpdateRequest;
use App\Collections\ProjectTypeCollection;
use App\Collections\ToolCategoryCollection;
use App\Collections\RemoteWorkingCollection;
use App\Collections\CommuteDistanceCollection;
use App\Collections\EducationalQualificationCollection;

class AccountController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except('show');
    }

    /**
     * Delete the current user's account.
     *
     */
    public function delete(DeleteRequest $request) : RedirectResponse
    {
        DeleteAction::execute(user());

        return redirect()
            ->route('home')
            ->notify('Your account has been deleted');
    }

    /**
     * Edit the current user's account.
     *
     */
    public function edit(EditRequest $request) : Response
    {
        return Page::make()
            ->title('Account')
            ->view('account.edit.index')
            ->with('countries', CountryCollection::make())
            ->with('languages', LanguageCollection::make())
            ->with('token', config('services.google.token'))
            ->with('currencies', CurrencyCollection::make())
            ->with('time_zones', TimeZoneCollection::make())
            ->with('remote', RemoteWorkingCollection::make())
            ->with('account', user()->only($request->fields))
            ->with('commute', CommuteDistanceCollection::make())
            ->with('email', config('mail.addresses.invitations'));
    }

    /**
     * Show the given user's account.
     *
     */
    public function show(User $user) : Response
    {
        return Page::make()
            ->meta($user)
            ->title($user->name)
            ->view('account.show.index')
            ->with('countries', CountryCollection::make())
            ->with('types', ProjectTypeCollection::make())
            ->with('time_zones', TimeZoneCollection::make())
            ->with('categories', ToolCategoryCollection::make())
            ->with('languages', LanguageCollection::list($user))
            ->with('account', ShowAction::execute($user, user(), member()))
            ->with('qualifications', EducationalQualificationCollection::make());
    }

    /**
     * Update the current user's account.
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
