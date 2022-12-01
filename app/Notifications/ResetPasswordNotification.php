<?php

namespace App\Notifications;

use App\Models\User;
use App\Types\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     */
    public string $token;

    /**
     * Constructor.
     *
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Generate a password reset url.
     *
     */
    protected function createUrl(User $user) : string
    {
        $parameters = [
            'token' => $this->token,
            'email' => $user->email,
        ];

        return route('password.reset', $parameters);
    }

    /**
     * Retrieve the mail representation of the notification.
     *
     */
    public function toMail($notifiable) : MailMessage
    {
        $payload = [
            'url' => $this->createUrl($notifiable),
        ];

        return (new MailMessage())
            ->subject('Reset Password')
            ->markdown('mail.password.reset', $payload);
    }
}
