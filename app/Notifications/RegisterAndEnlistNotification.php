<?php

namespace App\Notifications;

use App\Types\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterAndEnlistNotification extends Notification
{
    /**
     * The name of the organization.
     *
     */
    public string $organization;

    /**
     * The encrypted payload.
     *
     */
    public string $payload;

    /**
     * Constructor.
     *
     */
    public function __construct(string $organization, string $payload)
    {
        $this->payload      = $payload;
        $this->organization = $organization;
    }

    /**
     * Retrieve the mail representation of the notification.
     *
     */
    public function toMail($notifiable) : MailMessage
    {
        $parameters = [
            'organization' => $this->organization,
            'url'          => route('register', ['enlist' => $this->payload]),
        ];

        return (new MailMessage())
            ->subject('You have been invited to join Lumeno')
            ->markdown('mail.member.enlist', $parameters);
    }
}
