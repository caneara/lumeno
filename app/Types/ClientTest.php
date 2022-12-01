<?php

namespace App\Types;

use App\Support\Test;
use Laravel\Dusk\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class ClientTest extends TestCase
{
    use Test;
    use DatabaseMigrations;

    /**
     * Create the remote web driver instance.
     *
     */
    protected function driver() : RemoteWebDriver
    {
        $arguments = array_values(array_filter([
            '--disable-gpu',
            '--window-size=1920,1080',
            env('DUSK_HEADLESS', true) ? '--headless' : '',
        ]));

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                (new ChromeOptions())->addArguments($arguments)
            )
        );
    }

    /**
     * Create a new Browser instance.
     *
     */
    protected function newBrowser($driver) : Browser
    {
        return new Browser($driver);
    }

    /**
     * Prepare for the test execution.
     * @beforeClass
     *
     */
    public static function prepare() : void
    {
        static::startChromeDriver();
    }
}
