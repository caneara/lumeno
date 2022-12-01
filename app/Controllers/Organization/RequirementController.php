<?php

namespace App\Controllers\Organization;

use App\Models\Vacancy;
use App\Types\Controller;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;
use App\Actions\Requirement\StoreAction;
use App\Actions\Requirement\DeleteAction;
use App\Actions\Requirement\UpdateAction;
use App\Requests\Requirement\StoreRequest;
use App\Requests\Requirement\DeleteRequest;
use App\Requests\Requirement\UpdateRequest;

class RequirementController extends Controller
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
     * Delete an existing requirement.
     *
     */
    public function delete(DeleteRequest $request, Requirement $requirement) : JsonResponse
    {
        DeleteAction::execute($requirement);

        return response()->json('done');
    }

    /**
     * Store a new requirement.
     *
     */
    public function store(StoreRequest $request, Vacancy $vacancy) : JsonResponse
    {
        $requirement = StoreAction::execute($vacancy, $request->validated());

        return response()->json(['id' => $requirement->id]);
    }

    /**
     * Update an existing requirement.
     *
     */
    public function update(UpdateRequest $request, Requirement $requirement) : JsonResponse
    {
        UpdateAction::execute($requirement, $request->validated());

        return response()->json('done');
    }
}
