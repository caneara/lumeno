<?php

namespace Tests\Unit\Search\Engine;

use App\Search\Engine;
use App\Types\ServerTest;
use App\Models\Invitation;
use Tests\Workshops\EngineWorkshop;

class InvitationTest extends ServerTest
{
    /** @test */
    public function it_knows_if_a_user_can_be_invited_to_apply_for_a_vacancy() : void
    {
        $workshop = EngineWorkshop::build();

        $this->assertTrue(Engine::canSendInvitation($workshop->user, $workshop->vacancy));

        Invitation::factory()
            ->belongsTo($workshop->organization, $workshop->vacancy, $workshop->user)
            ->create();

        $this->assertFalse(Engine::canSendInvitation($workshop->user, $workshop->vacancy));
    }
}
