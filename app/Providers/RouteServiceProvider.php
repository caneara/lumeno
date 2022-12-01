<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The route files.
     *
     */
    protected array $files = [
        'Administration',
        'Authentication',
        'General',
        'Organization',
        'User',
    ];

    /**
     * Define the routes for the application.
     *
     */
    public function map() : void
    {
        $this->mapWebRoutes();
        $this->mapStorageRoutes();
    }

    /**
     * Define the local storage routes for the application.
     *
     */
    protected function mapStorageRoutes() : void
    {
        if (app()->isProduction()) {
            return;
        }

        Route::middleware('web')
            ->post('/vapor/signed-storage-url', fn() => $this->signedStorageUrl())
            ->name('signed.storage.url');

        Route::middleware(['web', 'signed'])
            ->put('/vapor/signed-storage-upload/{id}', fn() => $this->signedStorageUpload())
            ->name('signed.storage.upload');
    }

    /**
     * Define the web routes for the application.
     *
     */
    protected function mapWebRoutes() : void
    {
        foreach ($this->files as $file) {
            Route::middleware('web')
                ->namespace("App\Controllers\\{$file}")
                ->group(base_path("routes/{$file}.php"));
        }
    }

    /**
     * Move a signed file to a temporary location.
     *
     */
    protected function signedStorageUpload() : JsonResponse
    {
        Gate::authorize('uploadFiles', [user()]);

        Storage::put('tmp/' . request()->header('id'), request()->getContent());

        return response()->json('The file was uploaded', 200);
    }

    /**
     * Create a new signed storage url.
     *
     */
    protected function signedStorageUrl() : JsonResponse
    {
        Gate::authorize('uploadFiles', [user()]);

        $route = 'signed.storage.upload';

        $time = now()->addMinutes(5);

        $payload = [
            'uuid'    => $id = uuid(),
            'url'     => URL::temporarySignedRoute($route, $time, ['id' => $id]),
            'headers' => ['id' => $id],
        ];

        return response()->json($payload, 201);
    }
}
