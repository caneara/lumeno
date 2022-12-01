<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Types\Browser;
use App\Models\Project;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Collections\ProjectTypeCollection;

class ProjectTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_projects_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $project = Project::factory()
                ->belongsTo($user)
                ->create([
                    'title'   => Str::random(15),
                    'summary' => Str::random(50),
                ]);

            $browser->loginAs($user)
                ->visitRoute('projects')
                ->assertTitle('Projects')
                ->assertSee('Projects');

            $browser->assertSee($project->title)
                ->assertSee(ProjectTypeCollection::find($project->type)->name)
                ->assertSee($project->summary)
                ->assertSee(Str::upper($project->first_tag))
                ->assertSee(Str::upper($project->second_tag))
                ->assertSee(Str::upper($project->third_tag))
                ->assertSee(Str::upper($project->fourth_tag));

            $browser->assertSee('1 project')
                ->assertSee('10 permitted')
                ->assertSee('9 remaining');
        });
    }

    /** @test */
    public function a_user_can_store_a_project() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $project = Project::factory()
                ->belongsTo($user)
                ->make([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                ]);

            $browser->loginAs($user)
                ->visitRoute('projects')
                ->assertTitle('Projects')
                ->assertSee('Projects');

            $browser->assertSee('0 projects')
                ->assertSee('10 permitted')
                ->assertSee('10 remaining');

            $browser->action('create-project');

            $browser->assertRouteIs('projects.create')
                ->assertTitle('Projects')
                ->assertSee('Create Project');

            $browser->select('type', $project->type)
                ->type('title', $project->title)
                ->type('summary', $project->summary)
                ->keys('.tagify__input', $project->first_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $project->second_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $project->third_tag)
                ->keys('.tagify__input', '{tab}')
                ->keys('.tagify__input', $project->fourth_tag)
                ->keys('.tagify__input', '{tab}')
                ->attach('file', public_path('img/project.jpg'))
                ->attach('first_image', public_path('img/logo.png'))
                ->attach('second_image', public_path('img/logo.png'))
                ->attach('third_image', public_path('img/logo.png'))
                ->type('url', $project->url)
                ->push('create');

            $browser->assertRouteIs('projects.edit', ['project' => Project::first()])
                ->assertTitle('Projects')
                ->assertSee('Edit Project');

            $browser->assertSee('The project has been created');

            $browser->assertSelected('type', $project->type)
                ->assertInputValue('title', $project->title)
                ->assertInputValue('summary', $project->summary)
                ->assertSee($project->first_tag)
                ->assertSee($project->second_tag)
                ->assertSee($project->third_tag)
                ->assertSee($project->fourth_tag)
                ->assertInputValue('url', $project->url);
        });
    }

    /** @test */
    public function a_user_can_update_a_project() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $project = Project::factory()
                ->belongsTo($user)
                ->create([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                ]);

            $payload = Project::factory()
                ->belongsTo($user)
                ->make([
                    'title'      => Str::random(10),
                    'summary'    => Str::random(50),
                    'first_tag'  => Str::random(10),
                    'second_tag' => Str::random(10),
                    'third_tag'  => Str::random(10),
                    'fourth_tag' => Str::random(10),
                ]);

            $browser->loginAs($user)
                ->visitRoute('projects')
                ->assertTitle('Projects')
                ->assertSee('Projects');

            $browser->assertSee($project->title)
                ->assertSee(ProjectTypeCollection::find($project->type)->name)
                ->assertSee($project->summary)
                ->assertSee(Str::upper($project->first_tag))
                ->assertSee(Str::upper($project->second_tag))
                ->assertSee(Str::upper($project->third_tag))
                ->assertSee(Str::upper($project->fourth_tag));

            $browser->assertSee('1 project')
                ->assertSee('10 permitted')
                ->assertSee('9 remaining');

            $browser->context("projects-{$project->id}", "projects-{$project->id}-edit");

            $browser->assertRouteIs('projects.edit', ['project' => $project])
                ->assertTitle('Projects')
                ->assertSee('Edit Project');

            $browser->assertSelected('type', $project->type)
                ->assertInputValue('title', $project->title)
                ->assertInputValue('summary', $project->summary)
                ->assertSee($project->first_tag)
                ->assertSee($project->second_tag)
                ->assertSee($project->third_tag)
                ->assertSee($project->fourth_tag)
                ->assertInputValue('url', $project->url)
                ->pause();

            $browser->select('type', $payload->type)
                ->type('title', $payload->title)
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
                ->attach('file', public_path('img/project.jpg'))
                ->attach('first_image', public_path('img/logo.png'))
                ->attach('second_image', public_path('img/logo.png'))
                ->attach('third_image', public_path('img/logo.png'))
                ->type('url', $payload->url)
                ->push('save');

            $browser->assertRouteIs('projects.edit', ['project' => $project])
                ->assertTitle('Projects')
                ->assertSee('Edit Project');

            $browser->assertSee('The project has been updated');

            $browser->assertSelected('type', $payload->type)
                ->assertInputValue('title', $payload->title)
                ->assertInputValue('summary', $payload->summary)
                ->assertSee($payload->first_tag)
                ->assertSee($payload->second_tag)
                ->assertSee($payload->third_tag)
                ->assertSee($payload->fourth_tag)
                ->assertInputValue('url', $payload->url);
        });
    }

    /** @test */
    public function a_user_can_delete_a_project() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $project = Project::factory()
                ->belongsTo($user)
                ->create([
                    'title'   => Str::random(15),
                    'summary' => Str::random(50),
                ]);

            $browser->loginAs($user)
                ->visitRoute('projects')
                ->assertTitle('Projects')
                ->assertSee('Projects');

            $browser->assertSee($project->title)
                ->assertSee(ProjectTypeCollection::find($project->type)->name)
                ->assertSee($project->summary)
                ->assertSee(Str::upper($project->first_tag))
                ->assertSee(Str::upper($project->second_tag))
                ->assertSee(Str::upper($project->third_tag))
                ->assertSee(Str::upper($project->fourth_tag));

            $browser->assertSee('1 project')
                ->assertSee('10 permitted')
                ->assertSee('9 remaining');

            $browser->context("projects-{$project->id}", "projects-{$project->id}-delete")
                ->confirm();

            $browser->assertRouteIs('projects')
                ->assertTitle('Projects')
                ->assertSee('Projects');

            $browser->assertSee('The project has been deleted');

            $browser->assertDontSee($project->title)
                ->assertDontSee(ProjectTypeCollection::find($project->type)->name)
                ->assertDontSee($project->summary)
                ->assertDontSee(Str::upper($project->first_tag))
                ->assertDontSee(Str::upper($project->second_tag))
                ->assertDontSee(Str::upper($project->third_tag))
                ->assertDontSee(Str::upper($project->fourth_tag));

            $browser->assertSee('0 projects')
                ->assertSee('10 permitted')
                ->assertSee('10 remaining');
        });
    }
}
