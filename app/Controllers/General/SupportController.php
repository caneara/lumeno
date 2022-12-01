<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;

class SupportController extends Controller
{
    /**
     * Show the support page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Support')
            ->view('support.index')
            ->with('user', user())
            ->with('mail', config('mail.addresses'));
    }
}
