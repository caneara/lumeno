<?php

namespace App\Controllers\User;

use Inertia\Response;
use App\Models\School;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\School\ViewAction;
use App\Actions\School\StoreAction;
use App\Actions\School\DeleteAction;
use App\Actions\School\UpdateAction;
use App\Requests\School\StoreRequest;
use Illuminate\Http\RedirectResponse;
use App\Requests\School\DeleteRequest;
use App\Requests\School\UpdateRequest;
use App\Collections\EducationalQualificationCollection;

class SchoolController extends Controller
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
     * Delete the given school.
     *
     */
    public function delete(DeleteRequest $request, School $school) : RedirectResponse
    {
        DeleteAction::execute($school);

        return redirect()
            ->route('schools')
            ->notify('The school has been deleted');
    }

    /**
     * Show the schools page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Schools')
            ->view('schools.index')
            ->with('total', user()->schools()->count())
            ->with('schools', ViewAction::execute(user()))
            ->with('limit', config('system.limits.schools'))
            ->with('qualifications', EducationalQualificationCollection::make());
    }

    /**
     * Store a new school.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        StoreAction::execute(user(), $request->validated());

        return redirect()
            ->route('schools')
            ->notify('The school has been created');
    }

    /**
     * Update the given school.
     *
     */
    public function update(UpdateRequest $request, School $school) : RedirectResponse
    {
        UpdateAction::execute($school, $request->validated());

        return redirect()
            ->route('schools')
            ->notify('The school has been updated');
    }
}
