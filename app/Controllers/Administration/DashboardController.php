<?php

namespace App\Controllers\Administration;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Tool\MetricAction;
use App\Actions\Dashboard\Admin\MetricsAction;

class DashboardController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'employee']);
    }

    /**
     * Show the dashboard page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Dashboard')
            ->view('dashboard.admin.index')
            ->with('tools', MetricAction::execute())
            ->with('metrics', MetricsAction::execute(user()));
    }
}
