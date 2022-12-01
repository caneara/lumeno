<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exclusion List
    |--------------------------------------------------------------------------
    |
    | This value defines the routes that should be automatically excluded
    | from the front-end, either because they are sensitive in nature,
    | or because they will never be accessed by the SPA.
    |
    */

    'except' => [
        '_debugbar.*',
        'debugbar.*',
        'dusk.*',
        '_dusk.*',
        'ignition.*',
        'horizon.*',
        'admin.*',
        'paddle.*',
    ],

];
