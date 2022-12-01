<?php

namespace App\Notifications;

use App\Types\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PendingToolsNotification extends Notification
{
    /**
     * Retrieve the mail representation of the notification.
     *
     */
    public function toMail($notifiable) : MailMessage
    {
        return (new MailMessage())
            ->subject('Pending Tools')
            ->markdown('mail.tool.pending');
    }
}
