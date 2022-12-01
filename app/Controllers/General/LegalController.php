<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;

class LegalController extends Controller
{
    /**
     * Show the legal page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->title('Legal')
            ->view('legal.index')
            ->render();
    }
}
