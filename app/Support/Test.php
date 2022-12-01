<?php

namespace App\Support;

use App\Types\Browser;
use Database\Seeders\TriggerSeeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

trait Test
{
    /**
     * Flag for whether to seed the database.
     *
     */
    protected bool $seed = true;

    /**
     * The database seeder to use.
     *
     */
    protected string $seeder = TriggerSeeder::class;

    /**
     * Create the application.
     *
     */
    public function createApplication() : Application
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Perform the pre-testing operations.
     *
     */
    protected function setUp() : void
    {
        parent::setUp();

        Carbon::freeze();

        Http::preventStrayRequests();

        File::deleteDirectory(storage_path('framework/testing'), true);

        if (! env('APP_DUSK')) {
            return;
        }

        File::deleteDirectory(storage_path('framework/dusk/console'), true);
        File::deleteDirectory(storage_path('framework/dusk/screenshots'), true);

        Browser::$storeConsoleLogAt  = storage_path('framework/dusk/console');
        Browser::$storeScreenshotsAt = storage_path('framework/dusk/screenshots');
    }

    /**
     * Perform the post-testing operations.
     *
     */
    protected function tearDown() : void
    {
        File::deleteDirectory(storage_path('framework/testing'), true);

        if (env('APP_DUSK')) {
            File::deleteDirectory(storage_path('framework/dusk/console'), true);
        }

        parent::tearDown();
    }
}
