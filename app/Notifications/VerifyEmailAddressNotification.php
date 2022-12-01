<?php

namespace App\Notifications;

use App\Models\User;
use App\Types\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailAddressNotification extends Notification
{
    /**
     * Generate a temporary signed route.
     *
     */
    protected function createUrl(User $user) : string
    {
        $payload = [
            'id'   => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ];

        $time = now()->addMinutes(config('auth.verification.expire'));

        return URL::temporarySignedRoute('email.verify.confirm', $time, $payload);
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
            ->subject('Verify Email')
            ->markdown('mail.email.verify', $payload);
    }
}
