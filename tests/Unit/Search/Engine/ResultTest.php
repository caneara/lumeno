<?php

namespace Tests\Unit\Search\Engine;

use App\Search\Engine;
use App\Types\ServerTest;
use Tests\Workshops\EngineWorkshop;

class ResultTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_search() : void
    {
        $workshop = EngineWorkshop::build();

        $results = Engine::execute($workshop->vacancy->refresh());

        $this->assertCount(1, $results->items());

        $this->assertEquals($workshop->user->id, $results->items()[0]->id);
    }
}
