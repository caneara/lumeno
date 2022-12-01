<?php

namespace Tests\Integration\Administration;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Models\Category;
use App\Types\ServerTest;
use App\Models\Requirement;
use App\Collections\ToolCategoryCollection;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ToolTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_tools_page() : void
    {
        $user = User::factory()->employee()->create();

        $this->actingAs($user)
            ->get(route('tools'))
            ->assertSuccessful()
            ->assertPage('tools.index');
    }

    /** @test */
    public function a_user_can_search_for_tools_using_a_search_term() : void
    {
        $user = User::factory()->create();

        $sequence = new Sequence(
            ['name' => 'ABCD 1'],
            ['name' => 'ABCD 2'],
            ['name' => 'EFGH'],
        );

        Category::factory()
            ->with(3, Tool::class, [], $sequence)
            ->create();

        $json = [
            'data' => [
                [
                    'id'         => Tool::first()->id,
                    'name'       => Tool::first()->name,
                    'originated' => Tool::first()->originated,
                    'category'   => Category::first()->name,
                    'count'      => 0,
                    'notice'     => '0 professionals have experience with this tool',
                ], [
                    'id'         => Tool::second()->id,
                    'name'       => Tool::second()->name,
                    'originated' => Tool::second()->originated,
                    'category'   => Category::first()->name,
                    'count'      => 0,
                    'notice'     => '0 professionals have experience with this tool',
                ],
            ],
        ];

        $this->actingAs($user)
            ->postJson(route('tools.search') . '?search=abc&page=1&exact=0')
            ->assertSuccessful()
            ->assertJsonFragment($json);
    }

    /** @test */
    public function a_user_can_search_for_tools_using_an_identifier() : void
    {
        $user = User::factory()->create();

        $sequence = new Sequence(
            ['name' => 'ABCD 1'],
            ['name' => 'ABCD 2'],
            ['name' => 'EFGH'],
        );

        Category::factory()
            ->with(3, Tool::class, [], $sequence)
            ->create();

        $json = [
            'data' => [[
                'id'         => $tool = Tool::first()->id,
                'name'       => Tool::first()->name,
                'category'   => Category::first()->name,
                'originated' => Tool::first()->originated,
                'count'      => 0,
                'notice'     => '0 professionals have experience with this tool',
            ]],
        ];

        $this->actingAs($user)
            ->postJson(route('tools.search') . "?search={$tool}&page=1&exact=1")
            ->assertSuccessful()
            ->assertJsonFragment($json);
    }

    /** @test */
    public function a_user_can_store_a_tool() : void
    {
        ToolCategoryCollection::seed();

        $user = User::factory()->create();

        $payload = Tool::factory()
            ->belongsTo(Category::first())
            ->make();

        $this->actingAs($user)
            ->postJson(route('tools.store'), $payload->toArray())
            ->assertSuccessful()
            ->assertJsonFragment(['done']);

        $this->assertCount(1, Tool::get());

        $this->assertFalse(Tool::first()->approved);
        $this->assertEquals($payload->name, Tool::first()->name);
        $this->assertEquals($payload->originated, Tool::first()->originated);
        $this->assertTrue(Tool::first()->category->is(Category::first()));
    }

    /** @test */
    public function a_user_cannot_store_a_tool_when_it_would_create_a_duplicate() : void
    {
        ToolCategoryCollection::seed();

        $user = User::factory()->create();

        Tool::factory()
            ->belongsTo(Category::first())
            ->create(['name' => 'Test']);

        $payload = Tool::factory()
            ->belongsTo(Category::first())
            ->make(['name' => 'Test']);

        $this->actingAs($user)
            ->postJson(route('tools.store'), $payload->toArray())
            ->assertInvalid(['name' => 'The name has already been taken.']);
    }

    /** @test */
    public function a_user_can_update_a_tool() : void
    {
        ToolCategoryCollection::seed();

        $user = User::factory()->employee()->create();

        $tool = Tool::factory()
            ->belongsTo(Category::first())
            ->create(['approved' => false]);

        $payload = Tool::factory()
            ->belongsTo(Category::second())
            ->make(['approved' => true]);

        $this->actingAs($user)
            ->patchJson(route('tools.update', ['tool' => $tool]), $payload->toArray())
            ->assertRedirect('tools')
            ->assertNotification('The tool has been updated');

        $this->assertTrue($tool->fresh()->approved);
        $this->assertEquals($payload->name, $tool->fresh()->name);
        $this->assertEquals($payload->originated, $tool->fresh()->originated);
        $this->assertTrue($tool->fresh()->category->is(Category::second()));
    }

    /** @test */
    public function a_user_cannot_update_a_tool_when_it_would_create_a_duplicate() : void
    {
        ToolCategoryCollection::seed();

        $user = User::factory()->employee()->create();

        $tool_1 = Tool::factory()
            ->belongsTo(Category::first())
            ->create(['name' => 'Tool #1']);

        $tool_2 = Tool::factory()
            ->belongsTo(Category::first())
            ->create(['name' => 'Tool #2']);

        $payload = Tool::factory()
            ->belongsTo(Category::first())
            ->make(['name' => 'Tool #1']);

        $this->actingAs($user)
            ->patchJson(route('tools.update', ['tool' => $tool_2]), $payload->toArray())
            ->assertInvalid(['name' => 'The name has already been taken.']);
    }

    /** @test */
    public function a_user_can_delete_a_tool() : void
    {
        ToolCategoryCollection::seed();

        $user = User::factory()->employee()->create();

        $tool = Tool::factory()
            ->belongsTo(Category::first())
            ->create();

        Skill::factory()
            ->belongsTo(Tool::first())
            ->create();

        Requirement::factory()
            ->belongsTo(Tool::first())
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('tools.delete', ['tool' => $tool]))
            ->assertRedirect('tools')
            ->assertNotification('The tool has been deleted');

        $this->assertCount(0, Tool::get());
        $this->assertCount(0, Skill::get());
        $this->assertCount(0, Requirement::get());
    }
}
