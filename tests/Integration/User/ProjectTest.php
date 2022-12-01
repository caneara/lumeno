<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Storage\Image;
use App\Models\Project;
use App\Types\ServerTest;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ProjectTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_projects_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('projects'))
            ->assertSuccessful()
            ->assertPage('projects.view.index');
    }

    /** @test */
    public function a_user_can_create_a_project() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('projects.create'))
            ->assertSuccessful()
            ->assertPage('projects.create.index');
    }

    /** @test */
    public function a_user_can_edit_a_project() : void
    {
        $user = User::factory()->create();

        $project = Project::factory()
            ->belongsTo($user)
            ->create();

        $this->actingAs($user)
            ->get(route('projects.edit', ['project' => $project]))
            ->assertSuccessful()
            ->assertPage('projects.edit.index');
    }

    /** @test */
    public function a_user_can_store_a_project() : void
    {
        $user = User::factory()->create();

        $project = Project::factory()
            ->belongsTo($user)
            ->make([
                'summary'      => Str::random(300),
                'first_image'  => $image_1 = uuid(),
                'second_image' => $image_2 = uuid(),
                'third_image'  => $image_3 = uuid(),
            ]);

        Image::fake($image_1);
        Image::fake($image_2);
        Image::fake($image_3);

        $payload = array_merge(
            $project->toArray(),
            ['logo' => UploadedFile::fake()->image('logo.jpg', 512, 512)->size(1)]
        );

        $this->actingAs($user)
            ->postJson(route('projects.store'), $payload)
            ->assertRedirect(route('projects.edit', ['project' => Project::first()]))
            ->assertNotification('The project has been created');

        $this->assertCount(1, Project::get());

        $project = Project::first();

        $this->assertTrue($project->user->is($user));

        $this->assertEquals($project->url, $payload['url']);
        $this->assertEquals($project->title, $payload['title']);
        $this->assertEquals($project->summary, $payload['summary']);
        $this->assertEquals($project->first_tag, $payload['first_tag']);
        $this->assertEquals($project->second_tag, $payload['second_tag']);
        $this->assertEquals($project->third_tag, $payload['third_tag']);
        $this->assertEquals($project->fourth_tag, $payload['fourth_tag']);
        $this->assertEquals($project->first_image, $payload['first_image']);
        $this->assertEquals($project->second_image, $payload['second_image']);
        $this->assertEquals($project->third_image, $payload['third_image']);

        Image::assertExists($project->logo);
        Image::assertExists($project->first_image);
        Image::assertExists($project->second_image);
        Image::assertExists($project->third_image);
    }

    /** @test */
    public function a_user_cannot_store_a_project_if_they_have_reached_the_maximum_number_of_projects() : void
    {
        $user = User::factory()->create();

        config(['system.limits.projects' => 1]);

        Project::factory()
            ->belongsTo($user)
            ->create();

        $payload = Project::factory()
            ->belongsTo($user)
            ->make(['summary' => Str::random(300)]);

        $this->actingAs($user)
            ->postJson(route('projects.store'), $payload->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_a_project() : void
    {
        $user = User::factory()->create();

        $project = Project::factory()
            ->belongsTo($user)
            ->create();

        Image::fake($original_1 = $project->logo);
        Image::fake($original_2 = $project->first_image);
        Image::fake($original_3 = $project->second_image);
        Image::fake($original_4 = $project->third_image);

        $payload = Project::factory()
            ->belongsTo($user)
            ->make([
                'summary'      => Str::random(300),
                'first_image'  => $image_1 = uuid(),
                'second_image' => $image_2 = uuid(),
                'third_image'  => $image_3 = uuid(),
            ]);

        Image::fake($image_1);
        Image::fake($image_2);
        Image::fake($image_3);

        $payload = array_merge(
            $payload->toArray(),
            ['logo' => UploadedFile::fake()->image('logo.jpg', 512, 512)->size(1)]
        );

        $this->actingAs($user)
            ->patchJson(route('projects.update', ['project' => $project]), $payload)
            ->assertRedirect(route('projects.edit', ['project' => $project]))
            ->assertNotification('The project has been updated');

        $this->assertEquals($project->fresh()->url, $payload['url']);
        $this->assertEquals($project->fresh()->title, $payload['title']);
        $this->assertEquals($project->fresh()->summary, $payload['summary']);
        $this->assertEquals($project->fresh()->first_tag, $payload['first_tag']);
        $this->assertEquals($project->fresh()->second_tag, $payload['second_tag']);
        $this->assertEquals($project->fresh()->third_tag, $payload['third_tag']);
        $this->assertEquals($project->fresh()->fourth_tag, $payload['fourth_tag']);
        $this->assertEquals($project->fresh()->first_image, $payload['first_image']);
        $this->assertEquals($project->fresh()->second_image, $payload['second_image']);
        $this->assertEquals($project->fresh()->third_image, $payload['third_image']);

        Image::assertMissing($original_1);
        Image::assertMissing($original_2);
        Image::assertMissing($original_3);
        Image::assertMissing($original_4);

        Image::assertExists($project->fresh()->logo);
        Image::assertExists($project->fresh()->first_image);
        Image::assertExists($project->fresh()->second_image);
        Image::assertExists($project->fresh()->third_image);
    }

    /** @test */
    public function a_user_can_delete_a_project() : void
    {
        $user = User::factory()->create();

        $project = Project::factory()
            ->belongsTo($user)
            ->create();

        Image::fake($project->logo);
        Image::fake($project->first_image);
        Image::fake($project->second_image);
        Image::fake($project->third_image);

        $this->actingAs($user)
            ->deleteJson(route('projects.delete', ['project' => $project]))
            ->assertRedirect(route('projects'))
            ->assertNotification('The project has been deleted');

        $this->assertCount(0, Project::get());

        Image::assertMissing($project->logo);
        Image::assertMissing($project->first_image);
        Image::assertMissing($project->second_image);
        Image::assertMissing($project->third_image);
    }
}
