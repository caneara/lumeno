<?php

namespace App\Controllers\User;

use Inertia\Response;
use App\Responses\Page;
use App\Models\Workplace;
use App\Types\Controller;
use App\Actions\Workplace\ViewAction;
use Illuminate\Http\RedirectResponse;
use App\Actions\Workplace\StoreAction;
use App\Actions\Workplace\DeleteAction;
use App\Actions\Workplace\UpdateAction;
use App\Requests\Workplace\StoreRequest;
use App\Requests\Workplace\DeleteRequest;
use App\Requests\Workplace\UpdateRequest;

class WorkplaceController extends Controller
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
     * Delete the given workplace.
     *
     */
    public function delete(DeleteRequest $request, Workplace $workplace) : RedirectResponse
    {
        DeleteAction::execute($workplace);

        return redirect()
            ->route('workplaces')
            ->notify('The workplace has been deleted');
    }

    /**
     * Show the workplaces page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Workplaces')
            ->view('workplaces.index')
            ->with('total', user()->workplaces()->count())
            ->with('workplaces', ViewAction::execute(user()))
            ->with('limit', config('system.limits.workplaces'));
    }

    /**
     * Store a new workplace.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        StoreAction::execute(user(), $request->validated());

        return redirect()
            ->route('workplaces')
            ->notify('The workplace has been created');
    }

    /**
     * Update the given workplace.
     *
     */
    public function update(UpdateRequest $request, Workplace $workplace) : RedirectResponse
    {
        UpdateAction::execute($workplace, $request->validated());

        return redirect()
            ->route('workplaces')
            ->notify('The workplace has been updated');
    }
}
