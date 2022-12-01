<?php

namespace App\Controllers\General;

use App\Types\Controller;
use Illuminate\Http\JsonResponse;
use App\Actions\Image\StoreAction;
use App\Requests\Image\StoreRequest;

class ImageController extends Controller
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
     * Store a new image.
     *
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        $id = StoreAction::execute($request->uuid, $request->imageFormat());

        return response()->json(['id' => $id]);
    }
}
