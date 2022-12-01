<?php

namespace App\Jobs;

use App\Types\Job;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\Invitation;
use Illuminate\Support\Collection;
use App\Notifications\VacancyInvitationNotification;

class SendInvitationsJob extends Job
{
    /**
     * The fields to retrieve.
     *
     */
    protected array $fields = [
        'users.email',
        'users.handle',
        'users.coordinates',
        'invitations.id',
        'invitations.user_id',
        'invitations.vacancy_id',
    ];

    /**
     * The number of times the job may be attempted.
     *
     */
    public int $tries = 1;

    /**
     * Execute the job.
     *
     */
    public function handle() : void
    {
        $this->pipeline(microtime(true));
    }

    /**
     * Retrieve a batch of unsent invitations.
     *
     */
    protected function batch() : Collection
    {
        return Invitation::query()
            ->join('users', 'invitations.user_id', '=', 'users.id')
            ->whereNull('sending_at')
            ->limit(config('system.invitation_batch_size'))
            ->get($this->fields)
            ->toBase();
    }

    /**
     * Repeat the process when the conditions are correct.
     *
     */
    protected function finish(float $start, Collection $items) : void
    {
        sleep(config('system.invitation_batch_delay'));

        $under = $items->count() < config('system.invitation_batch_size');

        $short = (microtime(true) - $start) >= config('system.invitation_batch_duration');

        when(! $under && ! $short, fn() => $this->pipeline($start));
    }

    /**
     * Format the given invitation for use.
     *
     */
    protected function format(Invitation $invitation) : object
    {
        $vacancy = new Vacancy([
            'id' => $invitation->vacancy_id,
        ]);

        $user = new User([
            'id'          => $invitation->user_id,
            'email'       => $invitation->email,
            'handle'      => $invitation->handle,
            'coordinates' => $invitation->coordinates,
        ]);

        return (object) compact('invitation', 'vacancy', 'user');
    }

    /**
     * Update the current status of the given invitations.
     *
     */
    protected function mark(Collection $items, string $field) : void
    {
        $list = $items->map(fn($item) => $item->invitation->id);

        $query = Invitation::whereIn('id', $list);

        attempt(fn() => $query->update([$field => now()]));
    }

    /**
     * Execute the required steps in sequence.
     *
     */
    protected function pipeline(float $start) : void
    {
        retry(4, fn() => $this->batch(), 2500)
            ->map(fn($item)  => $this->format($item))
            ->tap(fn($items) => $this->mark($items, 'sending_at'))
            ->each(fn($item) => $this->send($item->user, $item->vacancy))
            ->tap(fn($items) => $this->mark($items, 'sent_at'))
            ->tap(fn($items) => $this->finish($start, $items));
    }

    /**
     * Send an invitation for the given vacancy to the given user.
     *
     */
    protected function send(User $user, Vacancy $vacancy) : void
    {
        $user->notify(new VacancyInvitationNotification($vacancy));
    }
}
