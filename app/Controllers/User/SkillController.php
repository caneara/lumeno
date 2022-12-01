<?php

namespace App\Controllers\User;

use App\Models\Skill;
use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Skill\ViewAction;
use App\Actions\Skill\SetupAction;
use App\Actions\Skill\StoreAction;
use App\Actions\Skill\DeleteAction;
use App\Actions\Skill\UpdateAction;
use App\Requests\Skill\SetupRequest;
use App\Requests\Skill\StoreRequest;
use App\Requests\Skill\DeleteRequest;
use App\Requests\Skill\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Collections\ToolCategoryCollection;
use App\Collections\YearsExperienceCollection;

class SkillController extends Controller
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
     * Delete the given skill.
     *
     */
    public function delete(DeleteRequest $request, Skill $skill) : RedirectResponse
    {
        DeleteAction::execute($skill);

        return redirect()
            ->route('skills')
            ->notify('The skill has been deleted');
    }

    /**
     * Show the skills page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Skills')
            ->view('skills.index')
            ->with('total', user()->skills()->count())
            ->with('skills', ViewAction::execute(user()))
            ->with('limit', config('system.limits.skills'))
            ->with('categories', ToolCategoryCollection::make())
            ->with('experience', YearsExperienceCollection::make());
    }

    /**
     * Set up the user's skills.
     *
     */
    public function setup(SetupRequest $request) : RedirectResponse
    {
        SetupAction::execute(user(), $request->validated());

        return redirect()
            ->route('skills')
            ->notify('The skills have been created');
    }

    /**
     * Store a new skill.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        StoreAction::execute(user(), $request->validated());

        return redirect()
            ->route('skills')
            ->notify('The skill has been created');
    }

    /**
     * Update the given skill.
     *
     */
    public function update(UpdateRequest $request, Skill $skill) : RedirectResponse
    {
        UpdateAction::execute($skill, $request->validated());

        return redirect()
            ->route('skills')
            ->notify('The skill has been updated');
    }
}
