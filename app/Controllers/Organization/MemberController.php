<?php

namespace App\Controllers\Organization;

use Inertia\Response;
use App\Models\Member;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Member\ViewAction;
use App\Actions\Member\StoreAction;
use App\Actions\Member\DeleteAction;
use App\Actions\Member\UpdateAction;
use App\Requests\Member\IndexRequest;
use App\Requests\Member\StoreRequest;
use Illuminate\Http\RedirectResponse;
use App\Requests\Member\DeleteRequest;
use App\Requests\Member\UpdateRequest;
use App\Collections\MemberRoleCollection;

class MemberController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'subscribed']);
    }

    /**
     * Delete the given member.
     *
     */
    public function delete(DeleteRequest $request, Member $member) : RedirectResponse
    {
        DeleteAction::execute($member);

        return redirect()
            ->route('members')
            ->notify('The member has been deleted');
    }

    /**
     * Show the members page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Members')
            ->view('members.index')
            ->with('roles', MemberRoleCollection::make())
            ->with('permissions', $request->permissions())
            ->with('total', organization()->metrics->member_count ?? 0)
            ->with('members', ViewAction::execute(organization(), member(), user(), $request->name ?? ''));
    }

    /**
     * Store a new member.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $result = StoreAction::execute(organization(), $request->email, $request->role)
            ? 'The member has been created'
            : 'The user has been invited to join';

        return redirect()
            ->route('members')
            ->notify($result);
    }

    /**
     * Update the given member.
     *
     */
    public function update(UpdateRequest $request, Member $member) : RedirectResponse
    {
        UpdateAction::execute($member, $request->role);

        return redirect()
            ->route('members')
            ->notify('The member has been updated');
    }
}
