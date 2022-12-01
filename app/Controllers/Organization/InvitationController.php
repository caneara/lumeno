<?php

namespace App\Controllers\Organization;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Invitation\BulkAction;
use App\Actions\Invitation\StoreAction;
use App\Requests\Invitation\BulkRequest;
use App\Requests\Invitation\StoreRequest;

class InvitationController extends Controller
{
    /**
     * The notification messages.
     *
     */
    protected array $messages = [
        StoreAction::SUCCESS       => 'The user or users have been invited',
        StoreAction::LOCKED_OUT    => 'Invites are already being sent, try again in a minute',
        StoreAction::PAYMENT_ERROR => 'Unable to bill for usage, review subscription or contact support',
    ];

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'subscribed']);
    }

    /**
     * Store multiple new invitations.
     *
     */
    public function bulk(BulkRequest $request, Vacancy $vacancy) : RedirectResponse
    {
        $response = BulkAction::execute(organization(), $vacancy, (int) $request->limit);

        return redirect()
            ->route('vacancies.show', ['vacancy' => $vacancy])
            ->notify(
                $this->messages[$response],
                $response === StoreAction::SUCCESS ? 'success' : 'error'
            );
    }

    /**
     * Store a new invitation.
     *
     */
    public function store(StoreRequest $request, Vacancy $vacancy, User $user) : RedirectResponse
    {
        $response = StoreAction::execute(organization(), $vacancy, $user);

        return back()->notify(
            $this->messages[$response],
            $response === StoreAction::SUCCESS ? 'success' : 'error'
        );
    }
}
