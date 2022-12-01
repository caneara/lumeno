<?php

namespace App\Controllers\User;

use Inertia\Response;
use App\Models\Project;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Project\ViewAction;
use App\Actions\Project\StoreAction;
use App\Actions\Project\DeleteAction;
use App\Actions\Project\UpdateAction;
use App\Requests\Project\EditRequest;
use Illuminate\Http\RedirectResponse;
use App\Requests\Project\StoreRequest;
use App\Requests\Project\DeleteRequest;
use App\Requests\Project\UpdateRequest;
use App\Collections\ProjectTypeCollection;

class ProjectController extends Controller
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
     * Create a new project.
     *
     */
    public function create() : Response
    {
        return Page::make()
            ->title('Projects')
            ->view('projects.create.index')
            ->with('types', ProjectTypeCollection::make());
    }

    /**
     * Delete the given project.
     *
     */
    public function delete(DeleteRequest $request, Project $project) : RedirectResponse
    {
        DeleteAction::execute($project);

        return redirect()
            ->route('projects')
            ->notify('The project has been deleted');
    }

    /**
     * Edit the given project.
     *
     */
    public function edit(EditRequest $request, Project $project) : Response
    {
        return Page::make()
            ->title('Projects')
            ->view('projects.edit.index')
            ->with('project', $project)
            ->with('types', ProjectTypeCollection::make());
    }

    /**
     * Show the projects page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Projects')
            ->view('projects.view.index')
            ->with('types', ProjectTypeCollection::make())
            ->with('projects', ViewAction::execute(user()))
            ->with('total', user()->metrics->project_count)
            ->with('limit', config('system.limits.projects'));
    }

    /**
     * Store a new project.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $project = StoreAction::execute(user(), $request->validated());

        return redirect()
            ->route('projects.edit', ['project' => $project])
            ->notify('The project has been created');
    }

    /**
     * Update the given project.
     *
     */
    public function update(UpdateRequest $request, Project $project) : RedirectResponse
    {
        UpdateAction::execute($project, $request->validated());

        return redirect()
            ->route('projects.edit', ['project' => $project])
            ->notify('The project has been updated');
    }
}
