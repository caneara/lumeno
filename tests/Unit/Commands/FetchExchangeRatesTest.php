<?php

namespace Tests\Unit\Commands;

use App\Types\ServerTest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

class FetchExchangeRatesTest extends ServerTest
{
    /** @test */
    public function it_schedules_the_command_to_run_every_day() : void
    {
        $event = collect(app()->make(Schedule::class)->events())
            ->first(fn(Event $event) => Str::endsWith($event->command, 'system:fetch-exchange-rates'));

        $this->assertEquals('0 0 * * *', $event->expression);
    }

    /** @test */
    public function it_fetches_the_current_exchange_rates() : void
    {
        DB::table('currencies')->insert([
            'id'     => 1,
            'code'   => 'GBP',
            'symbol' => '£',
            'name'   => 'Pound',
            'rate'   => 1,
        ]);

        DB::table('currencies')->insert([
            'id'     => 2,
            'code'   => 'EUR',
            'symbol' => '€',
            'name'   => 'Euro',
            'rate'   => 2,
        ]);

        $response = [
            'success' => true,
            'quotes'  => [
                'USDGBP' => 10,
                'USDEUR' => 20,
            ],
        ];

        Http::fake(['*' => Http::response($response)]);

        $this->artisan('system:fetch-exchange-rates')
            ->expectsOutput('The exchange rates have been retrieved');

        $this->assertCount(2, DB::table('currencies')->get());

        $this->assertEquals(0.1, DB::table('currencies')->find(1)->rate);
        $this->assertEquals(0.05, DB::table('currencies')->find(2)->rate);
    }
}
