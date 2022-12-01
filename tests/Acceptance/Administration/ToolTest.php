<?php

namespace Tests\Acceptance\Administration;

use App\Models\Tool;
use App\Models\User;
use App\Types\Browser;
use App\Models\Category;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Collections\ToolCategoryCollection;

class ToolTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_tools_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            $tool = Tool::factory()->create([
                'name'     => Str::random(20),
                'approved' => false,
            ]);

            $browser->loginAs($user)
                ->visitRoute('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee($tool->name)
                ->assertSee($tool->originated)
                ->assertSee(Str::upper('Pending'))
                ->assertSee($tool->category->name);

            $browser->assertSee('1 pending')
                ->assertSee('0 approved');
        });
    }

    /** @test */
    public function a_user_can_store_a_tool() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->make([
                    'name'     => Str::random(20),
                    'approved' => false,
                ]);

            $browser->loginAs($user)
                ->visitRoute('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->action('create-tool');

            $browser->assertSee('Add a missing tool');

            $browser->select('category_id', $tool->category_id)
                ->type('name', $tool->name)
                ->type('originated', $tool->originated)
                ->push('add');

            $browser->assertSee('The tool has been created')
                ->pause(2000)
                ->assertDontSee('The tool has been created');
        });
    }

    /** @test */
    public function a_user_can_update_a_tool() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create([
                    'name'     => Str::random(20),
                    'approved' => false,
                ]);

            $payload = Tool::factory()
                ->belongsTo(Category::second())
                ->make([
                    'name'       => Str::random(20),
                    'originated' => 2005,
                    'approved'   => true,
                ]);

            $browser->loginAs($user)
                ->visitRoute('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee($tool->name)
                ->assertSee($tool->originated)
                ->assertSee(Category::first()->name)
                ->assertSee(Str::upper('Pending'));

            $browser->context("tools-{$tool->id}", "tools-{$tool->id}-edit");

            $browser->assertSee('Edit an existing tool');

            $browser->assertSelected('category_id', $tool->category_id)
                ->assertInputValue('name', $tool->name)
                ->assertInputValue('originated', $tool->originated)
                ->assertChecked('approved', $tool->approved);

            $browser->select('category_id', $payload->category_id)
                ->type('name', $payload->name)
                ->type('originated', $payload->originated)
                ->check('approved')
                ->push('update');

            $browser->assertRouteIs('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee('The tool has been updated');

            $browser->assertSee($payload->name)
                ->assertSee($payload->originated)
                ->assertSee(Category::second()->name);

            $browser->assertDontSee($tool->name)
                ->assertDontSee($tool->originated)
                ->assertDontSee(Category::first()->name)
                ->assertDontSee(Str::upper('Pending'));
        });
    }

    /** @test */
    public function a_user_can_approve_a_tool() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create([
                    'name'     => Str::random(20),
                    'approved' => false,
                ]);

            $browser->loginAs($user)
                ->visitRoute('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee($tool->name)
                ->assertSee($tool->originated)
                ->assertSee(Str::upper('Pending'));

            $browser->context("tools-{$tool->id}", "tools-{$tool->id}-approve");

            $browser->assertRouteIs('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee('The tool has been updated');

            $browser->assertSee($tool->name)
                ->assertSee($tool->originated)
                ->assertDontSee(Str::upper('Pending'));
        });
    }

    /** @test */
    public function a_user_can_delete_a_tool() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            ToolCategoryCollection::seed();

            $tool = Tool::factory()
                ->belongsTo(Category::first())
                ->create([
                    'name'     => Str::random(20),
                    'approved' => false,
                ]);

            $browser->loginAs($user)
                ->visitRoute('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee($tool->name)
                ->assertSee($tool->originated)
                ->assertSee(Category::first()->name);

            $browser->context("tools-{$tool->id}", "tools-{$tool->id}-delete")
                ->confirm();

            $browser->assertRouteIs('tools')
                ->assertTitle('Tools')
                ->assertSee('Tools');

            $browser->assertSee('The tool has been deleted');

            $browser->assertDontSee($tool->name)
                ->assertDontSee($tool->originated)
                ->assertDontSee(Category::first()->name);
        });
    }
}
