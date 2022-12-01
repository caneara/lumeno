<?php

namespace App\Controllers\Organization;

use Inertia\Inertia;
use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Http\RedirectResponse;
use App\Actions\Organization\StoreAction;
use App\Actions\Organization\DeleteAction;
use App\Actions\Organization\UpdateAction;
use App\Requests\Organization\IndexRequest;
use App\Requests\Organization\StoreRequest;
use App\Requests\Organization\CreateRequest;
use App\Requests\Organization\DeleteRequest;
use App\Requests\Organization\UpdateRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrganizationController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->middleware('subscribed')->except(['create', 'store']);
    }

    /**
     * Create a new organization.
     *
     */
    public function create(CreateRequest $request) : Response
    {
        return Page::make()
            ->title('Organization')
            ->view('organization.create.index')
            ->render();
    }

    /**
     * Delete the organization.
     *
     */
    public function delete(DeleteRequest $request) : RedirectResponse
    {
        DeleteAction::execute(organization());

        return redirect()
            ->route('dashboard.user')
            ->notify('The organization has been deleted');
    }

    /**
     * Show the organization page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Organization')
            ->view('organization.view.index')
            ->with('organization', organization()->billing())
            ->with('subscription_plan', organization()->sparkPlan()->name);
    }

    /**
     * Store a new organization.
     *
     */
    public function store(StoreRequest $request) : HttpResponse
    {
        StoreAction::execute(user(), $request->validated());

        return Inertia::location(route('spark.portal', ['type' => 'organization']));
    }

    /**
     * Update the organization.
     *
     */
    public function update(UpdateRequest $request) : RedirectResponse
    {
        UpdateAction::execute(organization(), $request->validated());

        return redirect()
            ->route('organization')
            ->notify('The organization has been updated');
    }
}
