<?php

namespace App\Controllers\User;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;

class DashboardController extends Controller
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
     * Show the dashboard page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Dashboard')
            ->view('dashboard.user.index')
            ->with('created_at', user()->created_at);
    }
}
