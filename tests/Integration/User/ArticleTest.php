<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Storage\Image;
use App\Models\Article;
use App\Types\ServerTest;
use Illuminate\Support\Str;

class ArticleTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_articles_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles'))
            ->assertSuccessful()
            ->assertPage('articles.view.index');
    }

    /** @test */
    public function a_user_can_create_an_article() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.create'))
            ->assertSuccessful()
            ->assertPage('articles.create.index');
    }

    /** @test */
    public function a_user_can_show_an_article() : void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.show', ['article' => $article, 'slug' => $article->slug]))
            ->assertSuccessful()
            ->assertPage('articles.show.index');
    }

    /** @test */
    public function a_user_can_edit_an_article() : void
    {
        $user = User::factory()->create();

        $article = Article::factory()
            ->belongsTo($user)
            ->create();

        $this->actingAs($user)
            ->get(route('articles.edit', ['article' => $article]))
            ->assertSuccessful()
            ->assertPage('articles.edit.index');
    }

    /** @test */
    public function a_user_can_store_an_article() : void
    {
        $user = User::factory()->create();

        $payload = Article::factory()
            ->belongsTo($user)
            ->make([
                'content'    => Str::random(300),
                'banner'     => $id = uuid(),
                'created_at' => now(),
            ]);

        Image::fake($id);

        $this->actingAs($user)
            ->postJson(route('articles.store'), $payload->toArray())
            ->assertRedirect(route('articles.edit', ['article' => Article::first()]))
            ->assertNotification('The article has been created');

        $this->assertCount(1, Article::get());

        $this->assertTrue(Article::first()->user->is($user));

        $this->assertEquals(Article::first()->title, $payload->title);
        $this->assertEquals(Article::first()->summary, $payload->summary);
        $this->assertEquals(Article::first()->content, $payload->content);
        $this->assertEquals(Article::first()->banner, $payload->banner);
        $this->assertEquals(Article::first()->first_tag, $payload->first_tag);
        $this->assertEquals(Article::first()->second_tag, $payload->second_tag);
        $this->assertEquals(Article::first()->third_tag, $payload->third_tag);
        $this->assertEquals(Article::first()->fourth_tag, $payload->fourth_tag);
        $this->assertEquals(Article::first()->slug, Str::slug($payload->title));

        Image::assertExists(Article::first()->banner);
    }

    /** @test */
    public function a_user_can_update_an_article() : void
    {
        $user = User::factory()->create();

        $article = Article::factory()
            ->belongsTo($user)
            ->create(['slug' => 'this-is-a-test']);

        Image::fake($original = $article->banner);

        $payload = Article::factory()
            ->belongsTo($user)
            ->make([
                'content'    => Str::random(300),
                'banner'     => $id = uuid(),
                'created_at' => now(),
            ]);

        Image::fake($id);

        $this->actingAs($user)
            ->patchJson(route('articles.update', ['article' => $article]), $payload->toArray())
            ->assertRedirect(route('articles.edit', ['article' => $article]))
            ->assertNotification('The article has been updated');

        $this->assertEquals($article->fresh()->slug, 'this-is-a-test');
        $this->assertEquals($article->fresh()->title, $payload->title);
        $this->assertEquals($article->fresh()->summary, $payload->summary);
        $this->assertEquals($article->fresh()->content, $payload->content);
        $this->assertEquals($article->fresh()->banner, $payload->banner);
        $this->assertEquals($article->fresh()->first_tag, $payload->first_tag);
        $this->assertEquals($article->fresh()->second_tag, $payload->second_tag);
        $this->assertEquals($article->fresh()->third_tag, $payload->third_tag);
        $this->assertEquals($article->fresh()->fourth_tag, $payload->fourth_tag);

        Image::assertMissing($original);

        Image::assertExists($article->fresh()->banner);
    }

    /** @test */
    public function a_user_can_delete_an_article() : void
    {
        $user = User::factory()->create();

        $article = Article::factory()->belongsTo($user)->create([
            'content' => 'test' . Image::fake($embed = uuid()) . 'test',
        ]);

        Image::fake($article->banner);

        $this->actingAs($user)
            ->deleteJson(route('articles.delete', ['article' => $article]))
            ->assertRedirect(route('articles'))
            ->assertNotification('The article has been deleted');

        $this->assertCount(0, Article::get());

        Image::assertMissing($embed);

        Image::assertMissing($article->banner);
    }
}
