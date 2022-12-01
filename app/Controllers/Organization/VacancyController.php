<?php

namespace App\Controllers\Organization;

use Inertia\Response;
use App\Search\Engine;
use App\Models\Vacancy;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Support\Str;
use App\Actions\Vacancy\ViewAction;
use App\Actions\Vacancy\StoreAction;
use App\Actions\Vacancy\DeleteAction;
use App\Actions\Vacancy\ExportAction;
use App\Actions\Vacancy\UpdateAction;
use App\Requests\Vacancy\EditRequest;
use App\Requests\Vacancy\ShowRequest;
use Illuminate\Http\RedirectResponse;
use App\Collections\CountryCollection;
use App\Requests\Vacancy\IndexRequest;
use App\Requests\Vacancy\StoreRequest;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Requests\Vacancy\CreateRequest;
use App\Requests\Vacancy\DeleteRequest;
use App\Requests\Vacancy\ExportRequest;
use App\Requests\Vacancy\UpdateRequest;
use App\Requests\Vacancy\ArchiveRequest;
use App\Collections\WorkCommitmentCollection;
use App\Collections\YearsExperienceCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Actions\Requirement\ViewAction as ViewRequirementAction;

class VacancyController extends Controller
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
     * Archive the given vacancy.
     *
     */
    public function archive(ArchiveRequest $request, Vacancy $vacancy) : RedirectResponse
    {
        UpdateAction::execute($vacancy, ['archived_at' => now()]);

        return redirect()
            ->route('vacancies')
            ->notify('The vacancy has been archived');
    }

    /**
     * Show the vacancies page.
     *
     */
    public function create(CreateRequest $request) : Response
    {
        return Page::make()
            ->title('Vacancies')
            ->view('vacancies.create.index')
            ->with('organization', organization())
            ->with('token', config('services.google.token'))
            ->with('countries', CountryCollection::make())
            ->with('languages', LanguageCollection::make())
            ->with('currencies', CurrencyCollection::make())
            ->with('commitments', WorkCommitmentCollection::make());
    }

    /**
     * Delete the given vacancy.
     *
     */
    public function delete(DeleteRequest $request, Vacancy $vacancy) : RedirectResponse
    {
        DeleteAction::execute($vacancy);

        return redirect()
            ->route('vacancies')
            ->notify('The vacancy has been deleted');
    }

    /**
     * Edit the given vacancy.
     *
     */
    public function edit(EditRequest $request, Vacancy $vacancy) : Response
    {
        return Page::make()
            ->title('Vacancies')
            ->view('vacancies.edit.index')
            ->with('vacancy', $vacancy)
            ->with('token', config('services.google.token'))
            ->with('limit', config('system.limits.requirements'))
            ->with('countries', CountryCollection::make())
            ->with('languages', LanguageCollection::make())
            ->with('currencies', CurrencyCollection::make())
            ->with('experience', YearsExperienceCollection::make())
            ->with('commitments', WorkCommitmentCollection::make())
            ->with('requirements', ViewRequirementAction::execute($vacancy));
    }

    /**
     * Export the given vacancy's candidate list.
     *
     */
    public function export(ExportRequest $request, Vacancy $vacancy) : StreamedResponse
    {
        return response()->streamDownload(
            fn() => ExportAction::execute($vacancy),
            Str::snake("{$vacancy->role}.csv"),
            ExportAction::headers($vacancy)
        );
    }

    /**
     * Show the vacancies page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Vacancies')
            ->view('vacancies.view.index')
            ->with('permissions', $request->permissions())
            ->with('countries', CountryCollection::make())
            ->with('currencies', CurrencyCollection::make())
            ->with('commitments', WorkCommitmentCollection::make())
            ->with('total', organization()->metrics->vacancy_count ?? 0)
            ->with('vacancies', ViewAction::execute(organization(), user(), $request->role ?? ''));
    }

    /**
     * Show the given vacancy.
     *
     */
    public function show(ShowRequest $request, Vacancy $vacancy) : Response
    {
        return Page::make()
            ->title('Vacancies')
            ->view('vacancies.show.index')
            ->with('vacancy', $vacancy)
            ->with('users', Engine::execute($vacancy))
            ->with('countries', CountryCollection::make())
            ->with('currencies', CurrencyCollection::make())
            ->with('time_zones', TimeZoneCollection::make())
            ->with('total', $vacancy->metrics->invitation_count ?? 0)
            ->with('commitments', WorkCommitmentCollection::make());
    }

    /**
     * Store a new vacancy.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $vacancy = StoreAction::execute(organization(), $request->validated());

        return redirect()
            ->route('vacancies.edit', ['vacancy' => $vacancy])
            ->notify('The vacancy has been created')
            ->withData('scroll_to', 'requirements');
    }

    /**
     * Update the given vacancy.
     *
     */
    public function update(UpdateRequest $request, Vacancy $vacancy) : RedirectResponse
    {
        UpdateAction::execute($vacancy, $request->validated());

        return redirect()
            ->route('vacancies.edit', ['vacancy' => $vacancy])
            ->notify('The vacancy has been updated');
    }
}
