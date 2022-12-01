<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use Illuminate\Notifications\Messages\MailMessage;

class VacancyInvitationNotification extends Notification
{
    /**
     * The vacancy to be used.
     *
     */
    public Vacancy $vacancy;

    /**
     * Constructor.
     *
     */
    public function __construct(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy->exists ? $vacancy : Vacancy::find($vacancy->id);
    }

    /**
     * Calculate the distance in kilometers between the given coordinates.
     *
     */
    protected function distance(string $start, string $finish) : float
    {
        $deg_lat1 = (float) Str::before($start, ',');
        $deg_lng1 = (float) Str::after($start, ',');
        $deg_lat2 = (float) Str::before($finish, ',');
        $deg_lng2 = (float) Str::after($finish, ',');

        $delta_lat = sin(deg2rad($deg_lat2 - $deg_lat1) / 2.0);
        $delta_lng = sin(deg2rad($deg_lng2 - $deg_lng1) / 2.0);

        $formula = $delta_lat * $delta_lat + $delta_lng * $delta_lng * cos(deg2rad($deg_lat1)) * cos(deg2rad($deg_lat2));

        return 6371 * 2 * atan2(sqrt($formula), sqrt(1 - $formula));
    }

    /**
     * Generate the payload to use when rendering the mailable.
     *
     */
    protected function prepare(User $user) : array
    {
        $this->vacancy
            ->load('requirements.tool:id,name')
            ->orderRequirementsByPriority();

        return [
            'vacancy'    => $this->vacancy,
            'languages'  => LanguageCollection::list($this->vacancy),
            'country'    => CountryCollection::find($this->vacancy->country)->name,
            'currency'   => CurrencyCollection::find($this->vacancy->currency)->code,
            'account'    => URL::signedRoute('account.show', ['user' => $user->handle]),
            'distance'   => $this->distance($this->vacancy->coordinates, $user->coordinates),
        ];
    }

    /**
     * Retrieve the mail representation of the notification.
     *
     */
    public function toMail($notifiable) : MailMessage
    {
        return (new MailMessage())
            ->from(config('mail.addresses.invitations'), 'Lumeno')
            ->subject("Vacancy Invitation - {$this->vacancy->role}")
            ->replyTo($this->vacancy->email)
            ->markdown('mail.vacancy.invitation', $this->prepare($notifiable));
    }
}
