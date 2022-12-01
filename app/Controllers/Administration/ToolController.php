<?php

namespace App\Controllers\Administration;

use App\Models\Tool;
use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Tool\ViewAction;
use App\Actions\Tool\StoreAction;
use Illuminate\Http\JsonResponse;
use App\Actions\Tool\DeleteAction;
use App\Actions\Tool\MetricAction;
use App\Actions\Tool\SearchAction;
use App\Actions\Tool\UpdateAction;
use App\Requests\Tool\IndexRequest;
use App\Requests\Tool\StoreRequest;
use App\Requests\Tool\DeleteRequest;
use App\Requests\Tool\SearchRequest;
use App\Requests\Tool\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Collections\ToolCategoryCollection;
use Illuminate\Contracts\Pagination\Paginator;

class ToolController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->middleware('employee')->except(['search', 'store']);
    }

    /**
     * Delete the given tool.
     *
     */
    public function delete(DeleteRequest $request, Tool $tool) : RedirectResponse
    {
        DeleteAction::execute($tool);

        return redirect()
            ->route('tools')
            ->notify('The tool has been deleted');
    }

    /**
     * Show the tools page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Tools')
            ->view('tools.index')
            ->with('metrics', MetricAction::execute())
            ->with('categories', ToolCategoryCollection::make())
            ->with('tools', ViewAction::execute($request->name ?? ''));
    }

    /**
     * Search for an existing tool.
     *
     */
    public function search(SearchRequest $request) : Paginator
    {
        return SearchAction::execute(
            (bool) $request->exact,
            $request->search,
            (int) ($request->page ?? 1),
        );
    }

    /**
     * Store a new tool.
     *
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        StoreAction::execute($request->validated());

        return response()->json('done');
    }

    /**
     * Update the given tool.
     *
     */
    public function update(UpdateRequest $request, Tool $tool) : RedirectResponse
    {
        UpdateAction::execute($tool, $request->validated());

        return redirect()
            ->route('tools')
            ->notify('The tool has been updated');
    }
}
