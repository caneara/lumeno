<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     */
    public function index() : Response
    {
        return Page::make()
            ->view('home.index')
            ->render();
    }
}
