<?php

namespace Tests\Integration\Organization;

use App\Models\Tool;
use App\Models\User;
use App\Models\Member;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Requirement;
use App\Models\Organization;

class RequirementTest extends ServerTest
{
    /** @test */
    public function a_user_can_store_a_requirement() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $tool = Tool::factory()->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $payload = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool)
            ->make();

        $this->actingAs($user)
            ->postJson(route('requirements.store', ['vacancy' => $vacancy]), $payload->toArray())
            ->assertSuccessful()
            ->assertExactJson(['id' => Requirement::first()->id]);

        $this->assertCount(1, Requirement::get());

        $this->assertTrue(Requirement::first()->tool->is($tool));
        $this->assertTrue(Requirement::first()->vacancy->is($vacancy));
        $this->assertTrue(Requirement::first()->organization->is($organization));

        $this->assertEquals(Requirement::first()->years, $payload->years);
        $this->assertEquals(Requirement::first()->summary, $payload->summary);
        $this->assertEquals(Requirement::first()->optional, $payload->optional);
    }

    /** @test */
    public function a_user_cannot_store_a_requirement_if_it_would_create_a_duplicate() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $tool = Tool::factory()->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool)
            ->create();

        $payload = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool)
            ->make();

        $this->actingAs($user)
            ->postJson(route('requirements.store', ['vacancy' => $vacancy]), $payload->toArray())
            ->assertInvalid(['tool_id' => 'The tool id has already been taken.']);
    }

    /** @test */
    public function a_user_cannot_store_a_requirement_if_they_have_reached_the_maximum_number_of_requirements() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $tool = Tool::factory()->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        Requirement::factory()
            ->count(10)
            ->belongsTo($organization, $vacancy, $tool)
            ->create();

        $payload = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool)
            ->make();

        $this->actingAs($user)
            ->postJson(route('requirements.store', ['vacancy' => $vacancy]), $payload->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_a_requirement() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $tool_1 = Tool::factory()->create();
        $tool_2 = Tool::factory()->create();

        $requirement = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool_1)
            ->create();

        $payload = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool_2)
            ->make();

        $this->actingAs($user)
            ->patchJson(route('requirements.update', ['requirement' => $requirement]), $payload->toArray())
            ->assertSuccessful()
            ->assertJsonFragment(['done']);

        $this->assertTrue($requirement->fresh()->tool->is($tool_2));
        $this->assertTrue($requirement->fresh()->vacancy->is($vacancy));
        $this->assertTrue($requirement->fresh()->organization->is($organization));

        $this->assertEquals($requirement->fresh()->years, $payload->years);
        $this->assertEquals($requirement->fresh()->summary, $payload->summary);
        $this->assertEquals($requirement->fresh()->optional, $payload->optional);
    }

    /** @test */
    public function a_user_cannot_update_a_requirement_if_it_would_create_a_duplicate() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $tool_1 = Tool::factory()->create();
        $tool_2 = Tool::factory()->create();

        $requirement_1 = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool_1)
            ->create();

        $requirement_2 = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool_2)
            ->create();

        $payload = Requirement::factory()
            ->belongsTo($organization, $vacancy, $tool_2)
            ->make();

        $this->actingAs($user)
            ->patchJson(route('requirements.update', ['requirement' => $requirement_1]), $payload->toArray())
            ->assertInvalid(['tool_id' => 'The tool id has already been taken.']);
    }

    /** @test */
    public function a_user_can_delete_a_requirement() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $requirement = Requirement::factory()
            ->belongsTo($organization, $vacancy)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('requirements.delete', ['requirement' => $requirement]))
            ->assertSuccessful()
            ->assertJsonFragment(['done']);

        $this->assertCount(0, Requirement::get());
    }
}
