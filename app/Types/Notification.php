<?php

namespace App\Types;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Markdown;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    /**
     * The rendered mailable.
     *
     */
    protected MailMessage $mailable;

    /**
     * Verify that the email's action button uses the given label and url.
     *
     */
    public function assertAction(string $label, string $url, bool $query = true) : static
    {
        $action = $query ? $this->getActionUrl() : Str::before($this->getActionUrl(), '?');

        PHPUnit::assertEquals($action, $url);

        return $this->assertMessageContains($label);
    }

    /**
     * Verify that the email's from field matches the given address.
     *
     */
    public function assertFrom(string $address) : static
    {
        foreach ($this->mailable->from as $value) {
            if ($value === $address) {
                return $this;
            }
        }

        throw new Exception('The from address was not found in the email');
    }

    /**
     * Verify that the email's markdown path matches the given path.
     *
     */
    public function assertMarkdown(string $path) : static
    {
        PHPUnit::assertEquals($this->mailable->markdown, "mail.{$path}");

        return $this;
    }

    /**
     * Verify that the email's body contains the given text.
     *
     */
    public function assertMessageContains(string $text) : static
    {
        $body = resolve(Markdown::class)
            ->render($this->mailable->markdown, $this->mailable->viewData);

        PHPUnit::assertTrue(Str::contains($body->toHtml(), $text));

        return $this;
    }

    /**
     * Verify that the email's body does not contain the given text.
     *
     */
    public function assertMessageDoesntContain(string $text) : static
    {
        $body = resolve(Markdown::class)
            ->render($this->mailable->markdown, $this->mailable->viewData);

        PHPUnit::assertFalse(Str::contains($body->toHtml(), $text));

        return $this;
    }

    /**
     * Verify that the email's reply to field matches the given address.
     *
     */
    public function assertReplyTo(string $address) : static
    {
        foreach ($this->mailable->replyTo[0] as $value) {
            if ($value === $address) {
                return $this;
            }
        }

        throw new Exception('The reply to address was not found in the email');
    }

    /**
     * Verify that the email's subject matches the given subject.
     *
     */
    public function assertSubject(string $subject) : static
    {
        PHPUnit::assertEquals($this->mailable->subject, $subject);

        return $this;
    }

    /**
     * Verify that the email contains view data with the given key and value.
     *
     */
    public function assertViewData(string $key, $value) : static
    {
        PHPUnit::assertEquals($this->mailable->viewData[$key], $value);

        return $this;
    }

    /**
     * Retrieve the email's action button url.
     *
     */
    public function getActionUrl(string $key = 'url') : string
    {
        return $this->mailable->viewData[$key];
    }

    /**
     * Assign the notifiable model to use for testing.
     *
     */
    public function setRecipient(mixed $notifiable) : static
    {
        $this->mailable = $this->toMail($notifiable);

        return $this;
    }

    /**
     * Get the notification's default delivery channels.
     *
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }
}
