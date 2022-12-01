<?php

namespace Tests\Unit\Rules;

use App\Models\Tool;
use App\Types\ServerTest;
use App\Rules\MaxYearsExperienceRule;

class MaxYearsExperienceTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $tool_1 = Tool::factory()->create(['originated' => now()->year]);
        $tool_2 = Tool::factory()->create(['originated' => now()->subYears(1)->year]);
        $tool_3 = Tool::factory()->create(['originated' => now()->subYears(2)->year]);

        $rule_1 = ['years' => [MaxYearsExperienceRule::make($tool_1->id)]];
        $rule_2 = ['years' => [MaxYearsExperienceRule::make($tool_2->id)]];
        $rule_3 = ['years' => [MaxYearsExperienceRule::make($tool_3->id)]];

        $this->assertFalse(validator(['years' => 1], $rule_1)->fails());
        $this->assertTrue(validator(['years' => 2], $rule_1)->fails());

        $this->assertFalse(validator(['years' => 1], $rule_2)->fails());
        $this->assertTrue(validator(['years' => 2], $rule_2)->fails());

        $this->assertFalse(validator(['years' => 1], $rule_3)->fails());
        $this->assertFalse(validator(['years' => 2], $rule_3)->fails());
        $this->assertTrue(validator(['years' => 3], $rule_3)->fails());
    }
}
