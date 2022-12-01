<?php

namespace App\Middleware;

use Closure;
use App\Types\Model;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    /**
     * The model attributes to make available.
     *
     */
    protected array $attributes = [
        'member'       => ['id', 'role'],
        'organization' => ['id', 'name'],
        'user'         => ['id', 'name', 'type', 'avatar', 'handle', 'metrics'],
    ];

    /**
     * The root template.
     *
     */
    protected $rootView = 'app.index';

    /**
     * Retrieve the given attributes from the given model.
     *
     */
    protected function only(?Model $model, string $attributes) : Closure
    {
        $payload = $this->attributes[$attributes];

        return fn() => rescue(fn() => $model?->only($payload), null, false);
    }

    /**
     * Define the properties that are shared by default.
     *
     */
    public function share(Request $request) : array
    {
        return array_merge(parent::share($request), [
            'asset'        => asset(''),
            'storage'      => Storage::url(''),
            'guest'        => Auth::guest(),
            'user'         => $this->only(user(), 'user'),
            'member'       => $this->only(member(), 'member'),
            'organization' => $this->only(organization(), 'organization'),
            'data'         => fn() => rescue(fn() => session('data'), [], false),
            'notification' => fn() => rescue(fn() => session('notification'), null, false),
        ]);
    }
}
