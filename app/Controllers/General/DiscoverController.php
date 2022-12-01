<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;

class DiscoverController extends Controller
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
     * Show the discover page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Getting Started')
            ->view('discover.index')
            ->with('user', user());
    }
}
