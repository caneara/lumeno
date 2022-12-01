<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use App\Types\ServerTest;

class MemberTest extends ServerTest
{
    /** @test */
    public function it_knows_if_it_is_a_manager() : void
    {
        $member_1 = Member::factory()->create(['role' => Member::ROLE_MANAGER]);
        $member_2 = Member::factory()->create(['role' => Member::ROLE_ASSOCIATE]);

        $this->assertTrue($member_1->isManager());
        $this->assertFalse($member_2->isManager());
    }

    /** @test */
    public function it_knows_if_it_is_an_associate() : void
    {
        $member_1 = Member::factory()->create(['role' => Member::ROLE_MANAGER]);
        $member_2 = Member::factory()->create(['role' => Member::ROLE_ASSOCIATE]);

        $this->assertTrue($member_2->isAssociate());
        $this->assertFalse($member_1->isAssociate());
    }
}
