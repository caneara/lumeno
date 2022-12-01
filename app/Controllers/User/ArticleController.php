<?php

namespace App\Controllers\User;

use Inertia\Response;
use App\Models\Article;
use App\Responses\Page;
use App\Types\Controller;
use App\Actions\Article\ViewAction;
use App\Actions\Article\StoreAction;
use App\Actions\Article\DeleteAction;
use App\Actions\Article\UpdateAction;
use App\Requests\Article\EditRequest;
use Illuminate\Http\RedirectResponse;
use App\Requests\Article\IndexRequest;
use App\Requests\Article\StoreRequest;
use App\Requests\Article\DeleteRequest;
use App\Requests\Article\UpdateRequest;

class ArticleController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except('show');
    }

    /**
     * Create a new article.
     *
     */
    public function create() : Response
    {
        return Page::make()
            ->title('Articles')
            ->view('articles.create.index')
            ->render();
    }

    /**
     * Delete the given article.
     *
     */
    public function delete(DeleteRequest $request, Article $article) : RedirectResponse
    {
        DeleteAction::execute($article);

        return redirect()
            ->route('articles')
            ->notify('The article has been deleted');
    }

    /**
     * Edit the given article.
     *
     */
    public function edit(EditRequest $request, Article $article) : Response
    {
        return Page::make()
            ->title('Articles')
            ->view('articles.edit.index')
            ->with('article', $article);
    }

    /**
     * Show the articles page.
     *
     */
    public function index(IndexRequest $request) : Response
    {
        return Page::make()
            ->title('Articles')
            ->view('articles.view.index')
            ->with('total', user()->metrics->article_count)
            ->with('articles', ViewAction::execute(user(), $request->title ?? ''));
    }

    /**
     * Show the given article.
     *
     */
    public function show(Article $article, string $slug = '') : Response
    {
        return Page::make()
            ->meta($article)
            ->title($article->title)
            ->view('articles.show.index')
            ->with('article', $article->load('user:id,name,handle,avatar,metrics'));
    }

    /**
     * Store a new article.
     *
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $article = StoreAction::execute(user(), $request->validated());

        return redirect()
            ->route('articles.edit', ['article' => $article])
            ->notify('The article has been created');
    }

    /**
     * Update the given article.
     *
     */
    public function update(UpdateRequest $request, Article $article) : RedirectResponse
    {
        UpdateAction::execute($article, $request->validated());

        return redirect()
            ->route('articles.edit', ['article' => $article])
            ->notify('The article has been updated');
    }
}
