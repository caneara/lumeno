<?php

namespace Tests\Unit\Models;

use App\Models\Metric;
use App\Types\ServerTest;

class MetricTest extends ServerTest
{
    /** @test */
    public function it_can_fetch_the_value_for_a_metric() : void
    {
        Metric::updateOrCreate([
            'table' => 'users',
            'name'  => 'count',
        ], [
            'value' => '1',
        ]);

        $this->assertEquals('1', Metric::value('users'));
    }
}
