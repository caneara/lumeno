<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Support\Arr;

class EmployerController extends Controller
{
    /**
     * Show the employer page.
     *
     */
    public function index() : Response
    {
        $plans = collect(config('spark.billables.organization.plans'))
            ->map(fn($item) => Arr::only($item, ['name', 'prices']));

        return Page::make()
            ->title('Employers')
            ->view('employers.index')
            ->with('plans', $plans);
    }
}
