<?php

namespace Tests\Unit\Commands;

use App\Types\ServerTest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VacancyInvitationNotification;

class SendInvitationsTest extends ServerTest
{
    /** @test */
    public function it_schedules_the_command_to_run_every_minute() : void
    {
        $event = collect(app()->make(Schedule::class)->events())
            ->first(fn(Event $event) => Str::endsWith($event->command, 'system:send-invitations'));

        $this->assertEquals('* * * * *', $event->expression);
    }

    /** @test */
    public function it_sends_invitations_to_users() : void
    {
        Notification::fake();

        config(['system.invitation_batch_size' => 1]);
        config(['system.invitation_batch_delay' => 0]);

        $invitation_1 = Invitation::factory()->create(['sending_at' => null]);
        $invitation_2 = Invitation::factory()->create(['sending_at' => null]);

        $this->artisan('system:send-invitations')
            ->expectsOutput('The invitations have been sent');

        $this->assertEquals(now(), $invitation_1->fresh()->sending_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sending_at);

        $this->assertEquals(now(), $invitation_1->fresh()->sent_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sent_at);

        Notification::assertTimesSent(2, VacancyInvitationNotification::class);

        foreach ([$invitation_1, $invitation_2] as $invitation) {
            Notification::assertSent($invitation->user, VacancyInvitationNotification::class)
                ->assertFrom(config('mail.addresses.invitations'))
                ->assertSubject("Vacancy Invitation - {$invitation->vacancy->role}")
                ->assertMarkdown('vacancy.invitation')
                ->assertReplyTo($invitation->vacancy->email);
        }
    }

    /** @test */
    public function it_does_not_send_invitations_when_no_pending_invitations_are_present() : void
    {
        Notification::fake();

        config(['system.invitation_batch_delay' => 0]);

        $invitation_1 = Invitation::factory()->create(['sending_at' => now()->subMinute()]);
        $invitation_2 = Invitation::factory()->create(['sending_at' => now()->subHour()]);

        $this->artisan('system:send-invitations')
            ->expectsOutput('The invitations have been sent');

        $this->assertEquals(now()->subMinute(), $invitation_1->fresh()->sending_at);
        $this->assertEquals(now()->subHour(), $invitation_2->fresh()->sending_at);

        Notification::assertNothingSent();
    }

    /** @test */
    public function it_uses_throttling_when_hitting_the_batch_time_duration() : void
    {
        Notification::fake();

        config(['system.invitation_batch_size' => 1]);
        config(['system.invitation_batch_delay' => 0]);
        config(['system.invitation_batch_duration' => 0]);

        $invitation_1 = Invitation::factory()->create(['sending_at' => null]);
        $invitation_2 = Invitation::factory()->create(['sending_at' => null]);

        $this->artisan('system:send-invitations')
            ->expectsOutput('The invitations have been sent');

        $this->assertEquals(now(), $invitation_1->fresh()->sending_at);
        $this->assertNull($invitation_2->fresh()->sending_at);

        $this->assertEquals(now(), $invitation_1->fresh()->sent_at);
        $this->assertNull($invitation_2->fresh()->sent_at);

        Notification::assertTimesSent(1, VacancyInvitationNotification::class);

        Notification::assertSent($invitation_1->user, VacancyInvitationNotification::class)
            ->assertFrom(config('mail.addresses.invitations'))
            ->assertSubject("Vacancy Invitation - {$invitation_1->vacancy->role}")
            ->assertMarkdown('vacancy.invitation')
            ->assertReplyTo($invitation_1->vacancy->email);
    }

    /** @test */
    public function it_sends_invitations_that_were_not_previously_sent_because_of_throttling() : void
    {
        Notification::fake();

        config(['system.invitation_batch_size' => 1]);
        config(['system.invitation_batch_delay' => 0]);
        config(['system.invitation_batch_duration' => 0]);

        $invitation_1 = Invitation::factory()->create(['sending_at' => now()->subMinute()]);
        $invitation_2 = Invitation::factory()->create(['sending_at' => null]);
        $invitation_3 = Invitation::factory()->create(['sending_at' => null]);

        $this->artisan('system:send-invitations')
            ->expectsOutput('The invitations have been sent');

        $this->assertEquals(now()->subMinute(), $invitation_1->fresh()->sending_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sending_at);
        $this->assertNull($invitation_3->fresh()->sending_at);

        $this->assertNull($invitation_1->fresh()->sent_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sent_at);
        $this->assertNull($invitation_3->fresh()->sent_at);

        Notification::assertTimesSent(1, VacancyInvitationNotification::class);

        Notification::assertSent($invitation_2->user, VacancyInvitationNotification::class)
            ->assertFrom(config('mail.addresses.invitations'))
            ->assertSubject("Vacancy Invitation - {$invitation_2->vacancy->role}")
            ->assertMarkdown('vacancy.invitation')
            ->assertReplyTo($invitation_2->vacancy->email);

        $this->artisan('system:send-invitations')
            ->expectsOutput('The invitations have been sent');

        $this->assertEquals(now()->subMinute(), $invitation_1->fresh()->sending_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sending_at);
        $this->assertEquals(now(), $invitation_3->fresh()->sending_at);

        $this->assertNull($invitation_1->fresh()->sent_at);
        $this->assertEquals(now(), $invitation_2->fresh()->sent_at);
        $this->assertEquals(now(), $invitation_3->fresh()->sent_at);

        Notification::assertTimesSent(2, VacancyInvitationNotification::class);

        foreach ([$invitation_2, $invitation_3] as $invitation) {
            Notification::assertSent($invitation->user, VacancyInvitationNotification::class)
                ->assertFrom(config('mail.addresses.invitations'))
                ->assertSubject("Vacancy Invitation - {$invitation->vacancy->role}")
                ->assertMarkdown('vacancy.invitation')
                ->assertReplyTo($invitation->vacancy->email);
        }
    }
}
