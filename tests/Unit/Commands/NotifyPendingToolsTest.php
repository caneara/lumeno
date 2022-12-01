<?php

namespace Tests\Unit\Commands;

use App\Models\Tool;
use App\Types\ServerTest;
use Illuminate\Support\Str;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PendingToolsNotification;
use Illuminate\Notifications\AnonymousNotifiable;

class NotifyPendingToolsTest extends ServerTest
{
    /** @test */
    public function it_schedules_the_command_to_run_every_day() : void
    {
        $event = collect(app()->make(Schedule::class)->events())
            ->first(fn(Event $event) => Str::endsWith($event->command, 'system:notify-pending-tools'));

        $this->assertEquals('0 0 * * *', $event->expression);
    }

    /** @test */
    public function it_notifies_the_administrator_of_pending_tools() : void
    {
        Notification::fake();

        Tool::factory()->create(['approved' => false]);

        $this->artisan('system:notify-pending-tools')
            ->expectsOutput('The administrator has been notified');

        $user = (new AnonymousNotifiable())->route('mail', config('mail.addresses.support'));

        Notification::assertSent($user, PendingToolsNotification::class)
            ->assertSubject('Pending Tools')
            ->assertMarkdown('tool.pending');
    }

    /** @test */
    public function it_does_not_notify_the_administrator_when_there_are_no_pending_tools() : void
    {
        Notification::fake();

        Tool::factory()->create(['approved' => true]);

        $this->artisan('system:notify-pending-tools')
            ->expectsOutput('The administrator has been notified');

        Notification::assertNothingSent();
    }
}
