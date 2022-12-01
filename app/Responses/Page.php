<?php

namespace App\Responses;

use App\Types\Model;
use Inertia\Inertia;
use Inertia\Response;

class Page
{
    /**
     * The page description.
     *
     */
    protected string $description;

    /**
     * The page meta tags.
     *
     */
    protected array $meta;

    /**
     * The page robots.
     *
     */
    protected string $robots;

    /**
     * The page title.
     *
     */
    protected string $title;

    /**
     * The page view.
     *
     */
    protected string $view;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->view = '';

        $this->title = 'Lumeno';

        $this->robots = $this->requiresAuthentication() ? 'NOINDEX, NOFOLLOW' : 'INDEX, FOLLOW';

        $this->description = 'A portfolio and recruitment platform built for IT professionals.';

        $this->meta = $this->defaultMetaTags();
    }

    /**
     * Assign a description to the page.
     *
     */
    public function description(string $text) : static
    {
        $this->description = $text;

        return $this;
    }

    /**
     * Retrieve the default meta tags to use for the page.
     *
     */
    protected function defaultMetaTags() : array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'type'        => 'website',
            'url'         => request()->url(),
            'image'       => asset('img/card.png'),
            'twitter'     => [
                'type'    => 'summary_large_image',
            ],
        ];
    }

    /**
     * Determine if the current route requires an authenticated user.
     *
     */
    protected function requiresAuthentication() : bool
    {
        $middleware = request()->route()?->controllerMiddleware() ?? [];

        return in_array('auth', $middleware);
    }

    /**
     * Factory method.
     *
     */
    public static function make() : static
    {
        return new static();
    }

    /**
     * Assign the meta tags to the page.
     *
     */
    public function meta(array | Model $source) : static
    {
        $this->meta = is_array($source) ? $source : Meta::create($source);

        return $this;
    }

    /**
     * Assign a robots configuration to the page.
     *
     */
    public function render() : Response
    {
        Inertia::setRootView('app.index');

        return Inertia::render($this->view)
            ->with('title', $this->title)
            ->withViewData('meta', $this->meta)
            ->withViewData('title', $this->title)
            ->withViewData('robots', $this->robots)
            ->withViewData('description', $this->description);
    }

    /**
     * Assign a robots configuration to the page.
     *
     */
    public function robots(string $text) : static
    {
        $this->robots = $text;

        return $this;
    }

    /**
     * Assign a title to the page.
     *
     */
    public function title(string $text) : static
    {
        $this->title = "Lumeno - {$text}";

        return $this;
    }

    /**
     * Assign a view to the page.
     *
     */
    public function view(string $text) : static
    {
        $this->view = str_replace('.', '/', $text);

        return $this;
    }

    /**
     * Attach the given value to the page.
     *
     */
    public function with(string $key, mixed $value) : Response
    {
        return $this->render()
            ->with($key, $value);
    }

    /**
     * Attach the given value to the page.
     *
     */
    public function withViewData(string $key, mixed $value) : Response
    {
        return $this->render()
            ->withViewData($key, $value);
    }
}
