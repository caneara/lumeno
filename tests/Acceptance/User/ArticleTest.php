<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Types\Browser;
use App\Models\Article;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_articles_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $article = Article::factory()
                ->belongsTo($user)
                ->create([
                    'title'   => Str::random(15),
                    'content' => Str::random(200),
                ]);

            $browser->loginAs($user)
                ->visitRoute('articles')
                ->assertTitle('Articles')
                ->assertSee('Articles');

            $browser->assertSee($article->title)
                ->assertSee($article->summary)
                ->assertSee(Str::upper($article->first_tag))
                ->assertSee(Str::upper($article->second_tag))
                ->assertSee(Str::upper($article->third_tag))
                ->assertSee(Str::upper($article->fourth_tag));

            $browser->assertSee('1 article');
        });
    }

    /** @test */
    public function a_user_can_show_an_article() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $article = Article::factory()
                ->belongsTo($user)
                ->create([
                    'title'   => Str::random(15),
                    'content' => Str::random(200),
                ]);

            $browser->visitRoute('articles.show', ['article' => $article, 'slug' => $article->slug])
                ->assertTitle($article->title)
                ->assertSee($article->title);

            $browser->assertSee($user->name)
                ->assertSee($user->handle)
                ->assertSee('1 minute')
                ->assertSee($article->created_at->date())
                ->assertSee(Str::upper($article->first_tag))
                ->assertSee(Str::upper($article->second_tag))
                ->assertSee(Str::upper($article->third_tag))
                ->assertSee(Str::upper($article->fourth_tag))
                ->assertSee($article->content);
        });
    }

    /** @test */
    public function a_user_can_store_an_article() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $article = Article::factory()
                ->belongsTo($user)
                ->make([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'content'    => Str::random(200),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                    'created_at' => now(),
                ]);

            $browser->loginAs($user)
                ->visitRoute('articles')
                ->assertTitle('Articles')
                ->assertSee('Articles');

            $browser->assertSee('0 articles');

            $browser->action('create-article');

            $browser->assertRouteIs('articles.create')
                ->assertTitle('Articles')
                ->assertSee('Create Article')
                ->pause();

            $browser->type('title', $article->title)
                ->type('summary', $article->summary)
                ->keys('.tagify__input', $article->first_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $article->second_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $article->third_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $article->fourth_tag)
                ->keys('.tagify__input', '{tab}')
                ->attach('banner', public_path('img/logo.png'))
                ->type('markdown_editor', $article->content)
                ->push('create');

            $browser->assertRouteIs('articles.edit', ['article' => Article::first()])
                ->assertTitle('Articles')
                ->assertSee('Edit Article');

            $browser->assertSee('The article has been created');

            $browser->assertInputValue('title', $article->title)
                ->assertInputValue('summary', $article->summary)
                ->assertSee($article->first_tag)
                ->assertSee($article->second_tag)
                ->assertSee($article->third_tag)
                ->assertSee($article->fourth_tag)
                ->assertInputValue('markdown_editor', $article->content)
                ->assertDate('created_at', $article->created_at);
        });
    }

    /** @test */
    public function a_user_can_update_an_article() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $article = Article::factory()
                ->belongsTo($user)
                ->create([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'content'    => Str::random(200),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                    'created_at' => now(),
                ]);

            $payload = Article::factory()
                ->belongsTo($user)
                ->make([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'content'    => Str::random(200),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                    'created_at' => now()->subWeek(),
                ]);

            $browser->loginAs($user)
                ->visitRoute('articles')
                ->assertTitle('Articles')
                ->assertSee('Articles');

            $browser->assertSee($article->title)
                ->assertSee($article->summary)
                ->assertSee(Str::upper($article->first_tag))
                ->assertSee(Str::upper($article->second_tag))
                ->assertSee(Str::upper($article->third_tag))
                ->assertSee(Str::upper($article->fourth_tag));

            $browser->assertSee('1 article');

            $browser->context("articles-{$article->id}", "articles-{$article->id}-edit");

            $browser->assertSee('Edit Article');

            $browser->assertInputValue('title', $article->title)
                ->assertInputValue('summary', $article->summary)
                ->assertSee($article->first_tag)
                ->assertSee($article->second_tag)
                ->assertSee($article->third_tag)
                ->assertSee($article->fourth_tag)
                ->assertInputValue('markdown_editor', $article->content)
                ->assertDate('created_at', $article->created_at)
                ->pause();

            $browser->type('title', $payload->title)
                ->type('summary', $payload->summary)
                ->keys('.tagify__input', '{backspace}')
                ->keys('.tagify__input', '{backspace}')
                ->keys('.tagify__input', '{backspace}')
                ->keys('.tagify__input', '{backspace}')
                ->keys('.tagify__input', $payload->first_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $payload->second_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $payload->third_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $payload->fourth_tag)
                ->keys('.tagify__input', '{tab}')
                ->attach('banner', public_path('img/logo.png'))
                ->type('markdown_editor', $payload->content)
                ->date('created_at', $payload->created_at)
                ->push('update');

            $browser->assertRouteIs('articles.edit', ['article' => $article])
                ->assertTitle('Articles')
                ->assertSee('Edit Article');

            $browser->assertSee('The article has been updated');

            $browser->assertInputValue('title', $payload->title)
                ->assertInputValue('summary', $payload->summary)
                ->assertSee($payload->first_tag)
                ->assertSee($payload->second_tag)
                ->assertSee($payload->third_tag)
                ->assertSee($payload->fourth_tag)
                ->assertInputValue('markdown_editor', $payload->content)
                ->assertDate('created_at', $payload->created_at);
        });
    }

    /** @test */
    public function a_user_can_delete_an_article() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $article = Article::factory()
                ->belongsTo($user)
                ->create([
                    'title'     => Str::random(10),
                    'summary'   => Str::random(50),
                ]);

            $browser->loginAs($user)
                ->visitRoute('articles')
                ->assertTitle('Articles')
                ->assertSee('Articles');

            $browser->assertSee($article->title)
                ->assertSee($article->summary)
                ->assertSee(Str::upper($article->first_tag))
                ->assertSee(Str::upper($article->second_tag))
                ->assertSee(Str::upper($article->third_tag))
                ->assertSee(Str::upper($article->fourth_tag));

            $browser->assertSee('1 article');

            $browser->context("articles-{$article->id}", "articles-{$article->id}-delete")
                ->confirm();

            $browser->assertRouteIs('articles')
                ->assertTitle('Articles')
                ->assertSee('Articles');

            $browser->assertSee('The article has been deleted');

            $browser->assertDontSee($article->title)
                ->assertDontSee($article->summary)
                ->assertDontSee(Str::upper($article->first_tag))
                ->assertDontSee(Str::upper($article->second_tag))
                ->assertDontSee(Str::upper($article->third_tag))
                ->assertDontSee(Str::upper($article->fourth_tag));

            $browser->assertSee('0 articles');
        });
    }

    /** @test */
    public function a_user_can_upload_an_image_and_its_url_is_injected_into_the_markdown_editor() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visitRoute('articles.create')
                ->assertTitle('Articles')
                ->assertSee('Create Article');

            $browser->attach('markdown_editor_upload', public_path('img/logo.png'));

            $url = Storage::url(Storage::files('images')[0]);

            $browser->assertInputValue('markdown_editor', "![]({$url})");
        });
    }
}
