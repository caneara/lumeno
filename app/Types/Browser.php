<?php

namespace App\Types;

use GuzzleHttp\Client;
use App\Support\Carbon;
use Illuminate\Support\Str;
use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser as BaseBrowser;
use PHPUnit\Framework\Assert as PHPUnit;

class Browser extends BaseBrowser
{
    /**
     * Constructor.
     *
     */
    public function __construct($driver, $resolver = null)
    {
        parent::__construct($driver, $resolver);

        $this->setDownloadDirectory();
    }

    /**
     * Click on one of the page actions.
     *
     */
    public function action(string $name) : static
    {
        return $this->click("action-{$name}");
    }

    /**
     * Assert that the given file input has the given file.
     *
     */
    public function assertAttached($field, $value = null) : static
    {
        return $this->assertInputValue("{$field}_file_value", $value);
    }

    /**
     * Assert that the given checkbox is checked.
     *
     */
    public function assertChecked($field, $value = null) : static
    {
        if (is_bool($value)) {
            $value = $value ? '1' : '0';
        }

        return $this->assertInputValue($field, $value);
    }

    /**
     * Assert that the given field has the given date.
     *
     */
    public function assertDate(string $field, string | Carbon $value = '') : static
    {
        $value = is_string($value) ? $value : $value->format('Y-m-d');

        return $this->assertInputValue($field, $value);
    }

    /**
     * Assert that the given field has the given date and time.
     *
     */
    public function assertDateTime(string $field, string | Carbon $value = '') : static
    {
        $value = is_string($value) ? $value : $value->format("Y-m-d\TH:i:s");

        return $this->assertInputValue($field, $value);
    }

    /**
     * Assert that a file with the given file name was downloaded.
     *
     */
    public function assertDownloaded(string $file_name, int $wait_for = 3000) : static
    {
        $this->pause($wait_for);

        PHPUnit::assertCount(1, glob(getcwd() . "/storage/framework/testing/{$file_name}"));

        @unlink(glob(getcwd() . "/storage/framework/testing/{$file_name}")[0]);

        return $this;
    }

    /**
     * Assert that the given input field has the given value.
     *
     */
    public function assertInputValue($field, $value) : static
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        return parent::assertInputValue($field, $value);
    }

    /**
     * Assert that the given dropdown has the given value selected.
     *
     */
    public function assertSelected($field, $value) : static
    {
        if (is_bool($value)) {
            $value = (int) $value;
        }

        return parent::assertSelected($field, $value);
    }

    /**
     * Assert that the given field has the given time.
     *
     */
    public function assertTime(string $field, string | Carbon $value = null) : static
    {
        $value = is_null($value) ? '' : $value;

        $value = is_string($value) ? $value : $value->format('H:i');

        $value = filled($value) ? "{$value}:00" : '';

        return $this->assertInputValue($field, $value);
    }

    /**
     * Assert that the given title is the same as the page's title.
     *
     */
    public function assertTitle($title) : static
    {
        $name = config('app.name');

        $title = $title === $name ? $name : "{$name} - {$title}";

        $this->pause();

        return parent::assertTitle($title);
    }

    /**
     * Attach the file at the given path to the given field.
     *
     */
    public function attach($field, $path) : static
    {
        $field = Str::start($field, '@');

        return parent::attach($field, $path)->pause(2000);
    }

    /**
     * Select the given card using the given value.
     *
     */
    public function card(string $field, string | int | float $value) : static
    {
        return $this->click("card-{$field}-{$value}");
    }

    /**
     * Check the given checkbox.
     *
     */
    public function check($field, $value = null) : static
    {
        return $this->click($field);
    }

    /**
     * Click on the given Dusk selector.
     *
     */
    public function click($selector = null) : static
    {
        $selector = Str::startsWith($selector, '|') ? substr($selector, 1) : Str::start($selector, '@');

        return parent::click($selector)->pause(500);
    }

    /**
     * Accept the confirmation prompt.
     *
     */
    public function confirm() : static
    {
        parent::assertSee('Certain about this?');

        return $this->push('confirm-yes')->pause(1000);
    }

    /**
     * Open the given context menu and click on the given option.
     *
     */
    public function context(string $name, string $option) : static
    {
        return $this->menu("context-{$name}", "context-{$option}");
    }

    /**
     * Select the given date for the given field.
     *
     */
    public function date(string $field, string | Carbon $value) : static
    {
        $value = is_string($value) ? $value : $value->toW3cString();

        return $this->javascript("events.emit('set-date-for-{$field}', '{$value}')");
    }

    /**
     * Select the given date and time for the given field.
     *
     */
    public function dateTime(string $field, string | Carbon $value) : static
    {
        $value = is_string($value) ? $value : $value->toW3cString();

        return $this->javascript("events.emit('set-date-time-for-{$field}', '{$value}')");
    }

    /**
     * Switch to the given menu tab.
     *
     */
    public function goToTab(string $name) : static
    {
        return $this->scrollToTop()
            ->push("set-tab-{$name}")
            ->pause();
    }

    /**
     * Retrieve the iframe element on the page at the given index.
     *
     */
    public function iframe(int $index = 0) : static
    {
        $target = $this->driver->findElements(WebDriverBy::tagName('iframe'))[$index];

        $this->driver->switchTo()->frame($target);

        return $this;
    }

    /**
     * Assign the given value to the browser's local storage.
     *
     */
    public function localStorage(string $key, string $value) : static
    {
        return $this->javascript("window.localStorage.setItem('{$key}', '{$value}')");
    }

    /**
     * Execute the given JavaScript code.
     *
     */
    public function javascript(string $code) : static
    {
        return (tap($this)->script($code))->pause();
    }

    /**
     * Perform a lookup using the given parameters.
     *
     */
    public function lookup(string $field, string $search, $value, bool $assert = true) : static
    {
        $this->type("{$field}_search_display", $search)
            ->pause()
            ->click("lookup-${field}-item-$value");

        return $assert ? $this->assertInputValue($field, $value) : $this;
    }

    /**
     * Open the given menu and click on the given option.
     *
     */
    public function menu(string $name, string $option) : static
    {
        return $this->click("menu-{$name}")
            ->click($option);
    }

    /**
     * Exit the current iframe and return to the main page.
     *
     */
    public function page() : static
    {
        $this->driver->switchTo()->defaultContent();

        return $this->pause(1000);
    }

    /**
     * Pause for the given amount of milliseconds.
     *
     */
    public function pause($milliseconds = 500) : static
    {
        return parent::pause($milliseconds);
    }

    /**
     * Press the given button.
     *
     */
    public function push(string $field, int $pause = 1000) : static
    {
        return $this->click($field)->pause($pause);
    }

    /**
     * Scroll to the top of the page.
     *
     */
    public function scrollToTop() : static
    {
        return $this->javascript('window.scrollTo(0, 0)');
    }

    /**
     * Select the given value.
     *
     */
    public function select($field, $value = null) : static
    {
        if (is_bool($value)) {
            $value = (int) $value;
        }

        return parent::select($field, $value);
    }

    /**
     * Configure Chrome to download files to the current directory.
     *
     */
    protected function setDownloadDirectory() : void
    {
        $payload = [
            'body' => json_encode([
                'cmd'    => 'Page.setDownloadBehavior',
                'params' => [
                    'behavior'     => 'allow',
                    'downloadPath' => getcwd() . '/storage/framework/testing/',
                ],
            ]),
        ];

        $id = $this->driver->getSessionID();

        $address = $this->driver
            ->getCommandExecutor()
            ->getAddressOfRemoteServer();

        (new Client())->post("{$address}/session/{$id}/chromium/send_command", $payload);
    }

    /**
     * Change the browser's focus to the first tab.
     *
     */
    public function switchToFirstTab() : static
    {
        $window = collect($this->driver->getWindowHandles())->first();

        $this->driver->switchTo()->window($window);

        return $this->pause(1000);
    }

    /**
     * Change the browser's focus to the last tab.
     *
     */
    public function switchToLastTab() : static
    {
        $window = collect($this->driver->getWindowHandles())->last();

        $this->driver->switchTo()->window($window);

        return $this->pause(1000);
    }

    /**
     * Select the given time for the given field.
     *
     */
    public function time(string $field, string | Carbon $value) : static
    {
        $value = is_string($value) ? new Carbon($value) : $value;

        return $this->select("{$field}_hour", $value->hour)
            ->select("{$field}_minute", $value->minute);
    }

    /**
     * Type the given value into the given field.
     *
     */
    public function type($field, $value) : static
    {
        return parent::type($field, (string) $value);
    }
}
