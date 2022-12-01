<?php

namespace Tests\Integration\User;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Types\ServerTest;

class SkillTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_skills_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('skills'))
            ->assertSuccessful()
            ->assertPage('skills.index');
    }

    /** @test */
    public function a_user_can_store_a_skill() : void
    {
        $user = User::factory()->create();

        $skill = Skill::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('skills.store'), $skill->toArray())
            ->assertRedirect(route('skills'))
            ->assertNotification('The skill has been created');

        $this->assertCount(1, Skill::get());

        $this->assertTrue(Skill::first()->user->is($user));

        $this->assertEquals($skill->years, Skill::first()->years);
        $this->assertEquals($skill->summary, Skill::first()->summary);
    }

    /** @test */
    public function a_user_can_setup_their_skills() : void
    {
        $user = User::factory()->create();

        $tool_1 = Tool::factory()->create(['name' => 'JavaScript']);
        $tool_2 = Tool::factory()->create(['name' => 'HTML']);
        $tool_3 = Tool::factory()->create(['name' => 'CSS']);

        $payload = [
            'javascript' => 1,
            'html'       => 2,
            'css'        => 3,
        ];

        $this->actingAs($user)
            ->postJson(route('skills.setup'), $payload)
            ->assertRedirect(route('skills'))
            ->assertNotification('The skills have been created');

        $skills = Skill::orderBy('years')->get();

        $this->assertCount(3, $skills);

        $this->assertTrue($skills[0]->user->is($user));
        $this->assertTrue($skills[1]->user->is($user));
        $this->assertTrue($skills[2]->user->is($user));

        $this->assertTrue($skills[0]->tool->is($tool_1));
        $this->assertTrue($skills[1]->tool->is($tool_2));
        $this->assertTrue($skills[2]->tool->is($tool_3));

        $this->assertEquals(1, $skills[0]->years);
        $this->assertEquals(2, $skills[1]->years);
        $this->assertEquals(3, $skills[2]->years);

        $this->assertNull($skills[0]->summary);
        $this->assertNull($skills[1]->summary);
        $this->assertNull($skills[2]->summary);
    }

    /** @test */
    public function a_user_cannot_store_a_skill_if_it_would_create_a_duplicate() : void
    {
        $user = User::factory()->create();

        $tool = Tool::factory()->create();

        Skill::factory()
            ->belongsTo($user, $tool)
            ->create();

        $payload = Skill::factory()
            ->belongsTo($user, $tool)
            ->make();

        $this->actingAs($user)
            ->postJson(route('skills.store'), $payload->toArray())
            ->assertInvalid(['tool_id' => 'This tool is already in your skill list']);
    }

    /** @test */
    public function a_user_cannot_store_a_skill_if_they_have_reached_the_maximum_number_of_skills() : void
    {
        $user = User::factory()->create();

        config(['system.limits.skills' => 1]);

        Skill::factory()
            ->belongsTo($user)
            ->create();

        $skill = Skill::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('skills.store'), $skill->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_a_skill() : void
    {
        $user = User::factory()->create();

        $skill = Skill::factory()
            ->belongsTo($user)
            ->create();

        $payload = Skill::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->patchJson(route('skills.update', ['skill' => $skill]), $payload->toArray())
            ->assertRedirect(route('skills'))
            ->assertNotification('The skill has been updated');

        $this->assertEquals($skill->fresh()->years, $payload->years);
        $this->assertEquals($skill->fresh()->summary, $payload->summary);
    }

    /** @test */
    public function a_user_can_delete_a_skill() : void
    {
        $user = User::factory()->create();

        $skill = Skill::factory()
            ->belongsTo($user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('skills.delete', ['skill' => $skill]))
            ->assertRedirect(route('skills'))
            ->assertNotification('The skill has been deleted');

        $this->assertCount(0, Skill::get());
    }
}
