<?php

namespace App\Controllers\General;

use Inertia\Response;
use App\Responses\Page;
use App\Types\Controller;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    /**
     * Show a page within the product guide.
     *
     */
    public function index(string $page = 'introduction') : Response
    {
        return Page::make()
            ->title(Str::title("Guide - {$page}"))
            ->view('guide.index')
            ->with('page', $page ?? 'introduction');
    }
}
