<?php

namespace Tests\Acceptance\User;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Types\Browser;
use App\Models\Category;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Collections\ToolCategoryCollection;

class SkillTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_skills_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create([
                    'name'     => Str::random(20),
                    'approved' => false,
                ]);

            $skill = Skill::factory()
                ->belongsTo($user, $tool)
                ->create(['years' => 5]);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee($tool->name)
                ->assertSee(Str::upper('Pending'))
                ->assertSee(Category::first()->name)
                ->assertSee("{$skill->years} years");

            $browser->assertSee('1 skill')
                ->assertSee('25 permitted')
                ->assertSee('24 remaining');
        });
    }

    /** @test */
    public function a_user_can_store_a_skill() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create([
                    'name'     => Str::random(20),
                    'approved' => true,
                ]);

            $skill = Skill::factory()
                ->belongsTo($user, $tool)
                ->make(['summary' => Str::random(20)]);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->action('create-skill');

            $browser->assertSee('Add a new skill');

            $browser->lookup('tool_id', $tool->name, $tool->id)
                ->select('years', $skill->years)
                ->type('summary', $skill->summary)
                ->push('create');

            $browser->assertRouteIs('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('The skill has been created');

            $browser->assertSee($tool->name)
                ->assertDontSee(Str::upper('Pending'))
                ->assertSee(Category::first()->name)
                ->assertSee($skill->years . ' ' . Str::plural('year', $skill->years));
        });
    }

    /** @test */
    public function a_user_can_setup_their_skills() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $tool_1 = Tool::factory()->create(['name' => 'JavaScript']);
            $tool_2 = Tool::factory()->create(['name' => 'HTML']);
            $tool_3 = Tool::factory()->create(['name' => 'CSS']);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('Getting started');

            $browser->push('select-javascript')
                ->assertDialogOpened('How many years experience do you have?')
                ->typeInDialog('1')
                ->acceptDialog()
                ->push('select-html')
                ->assertDialogOpened('How many years experience do you have?')
                ->typeInDialog('2')
                ->acceptDialog()
                ->push('select-css')
                ->assertDialogOpened('How many years experience do you have?')
                ->typeInDialog('3')
                ->acceptDialog()
                ->push('save');

            $browser->assertRouteIs('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('The skills have been created');

            $browser->assertDontSee('Getting started');

            $browser->assertSee($tool_1->name)
                ->assertSee($tool_2->name)
                ->assertSee($tool_3->name)
                ->assertSee('1 year')
                ->assertSee('2 years')
                ->assertSee('3 years');
        });
    }

    /** @test */
    public function a_user_can_store_a_skill_with_a_missing_tool() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->make(['name' => Str::random(20)]);

            $skill = Skill::factory()
                ->belongsTo($user, $tool)
                ->make(['summary' => Str::random(20)]);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->action('create-tool');

            $browser->assertSee('Add a missing tool');

            $browser->select('category_id', $tool->category_id)
                ->type('name', $tool->name)
                ->type('originated', $tool->originated)
                ->push('add');

            $browser->assertSee('The tool has been created')
                ->pause(2000)
                ->assertDontSee('The tool has been created');

            $browser->javascript("window.events.emit('hide-create-tool-modal')");

            $browser->action('create-skill');

            $browser->assertSee('Add a new skill');

            $browser->lookup('tool_id', $tool->name, Tool::first()->id)
                ->select('years', $skill->years)
                ->type('summary', $skill->summary)
                ->push('create');

            $browser->assertRouteIs('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('The skill has been created');

            $browser->assertSee($tool->name)
                ->assertSee(Str::upper('Pending'))
                ->assertSee(Category::first()->name)
                ->assertSee($skill->years . ' ' . Str::plural('year', $skill->years));
        });
    }

    /** @test */
    public function a_user_can_update_a_skill() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create(['name' => Str::random(20)]);

            $skill = Skill::factory()
                ->belongsTo($user, $tool)
                ->create([
                    'years'   => 3,
                    'summary' => Str::random(20),
                ]);

            $payload = Skill::factory()
                ->belongsTo($user, $tool)
                ->make([
                    'years'   => 5,
                    'summary' => Str::random(20),
                ]);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee($tool->name)
                ->assertSee(Category::first()->name)
                ->assertSee($skill->years . ' ' . Str::plural('year', $skill->years));

            $browser->context("skills-{$skill->id}", "skills-{$skill->id}-edit");

            $browser->assertSee('Edit an existing skill');

            $browser->assertInputValue('tool', $tool->name)
                ->assertSelected('years', $skill->years)
                ->assertInputValue('summary', $skill->summary);

            $browser->select('years', $payload->years)
                ->type('summary', $payload->summary)
                ->push('update');

            $browser->assertRouteIs('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('The skill has been updated');

            $browser->assertDontSee($skill->summary)
                ->assertDontSee("{$skill->years} years")
                ->assertSee($payload->years . ' ' . Str::plural('year', $skill->years));
        });
    }

    /** @test */
    public function a_user_can_delete_a_skill() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create(['name' => Str::random(20)]);

            $skill = Skill::factory()
                ->belongsTo($user, $tool)
                ->create([
                    'years'   => 3,
                    'summary' => Str::random(20),
                ]);

            $browser->loginAs($user)
                ->visitRoute('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee($tool->name)
                ->assertSee(Category::first()->name)
                ->assertSee("{$skill->years} years");

            $browser->context("skills-{$skill->id}", "skills-{$skill->id}-delete");

            $browser->assertRouteIs('skills')
                ->assertTitle('Skills')
                ->assertSee('Skills');

            $browser->assertSee('The skill has been deleted');

            $browser->assertDontSee($tool->name)
                ->assertDontSee(Category::first()->name)
                ->assertDontSee("{$skill->years} years");
        });
    }
}
