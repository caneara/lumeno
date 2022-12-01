<?php

return [

    /*
    |-----------------------------------------------------------------------
    | Enable Clockwork
    |-----------------------------------------------------------------------
    |
    | Clockwork is enabled by default only when your application is in
    | debug mode. Here you can explicitly enable or disable Clockwork.
    | When off, no data is collected and the api and web ui are inactive.
    |
    */

    'enable' => env('CLOCKWORK_ENABLE', null),

    /*
    |-----------------------------------------------------------------------
    | Features
    |-----------------------------------------------------------------------
    |
    | You can enable or disable various Clockwork features here. Some
    | features have additional settings (eg. slow query threshold).
    |
    */

    'features' => [

        'cache' => [
            'enabled'         => env('CLOCKWORK_CACHE_ENABLED', true),
            'collect_queries' => env('CLOCKWORK_CACHE_QUERIES', true),
            'collect_values'  => env('CLOCKWORK_CACHE_COLLECT_VALUES', false),
        ],

        'database' => [
            'enabled'                  => env('CLOCKWORK_DATABASE_ENABLED', true),
            'collect_queries'          => env('CLOCKWORK_DATABASE_COLLECT_QUERIES', true),
            'collect_models_actions'   => env('CLOCKWORK_DATABASE_COLLECT_MODELS_ACTIONS', true),
            'collect_models_retrieved' => env('CLOCKWORK_DATABASE_COLLECT_MODELS_RETRIEVED', false),
            'slow_threshold'           => env('CLOCKWORK_DATABASE_SLOW_THRESHOLD'),
            'slow_only'                => env('CLOCKWORK_DATABASE_SLOW_ONLY', false),
            'detect_duplicate_queries' => env('CLOCKWORK_DATABASE_DETECT_DUPLICATE_QUERIES', false),
        ],

        'events' => [
            'enabled'        => env('CLOCKWORK_EVENTS_ENABLED', true),
            'ignored_events' => [],
        ],

        'log' => [
            'enabled' => env('CLOCKWORK_LOG_ENABLED', true),
        ],

        'notifications' => [
            'enabled' => env('CLOCKWORK_NOTIFICATIONS_ENABLED', true),
        ],

        'performance' => [
            'client_metrics' => env('CLOCKWORK_PERFORMANCE_CLIENT_METRICS', true),
        ],

        'queue' => [
            'enabled' => env('CLOCKWORK_QUEUE_ENABLED', true),
        ],

        'redis' => [
            'enabled' => env('CLOCKWORK_REDIS_ENABLED', true),
        ],

        'routes' => [
            'enabled'         => env('CLOCKWORK_ROUTES_ENABLED', false),
            'only_namespaces' => ['App'],
        ],

        'views' => [
            'enabled'           => env('CLOCKWORK_VIEWS_ENABLED', true),
            'collect_data'      => env('CLOCKWORK_VIEWS_COLLECT_DATA', false),
            'use_twig_profiler' => env('CLOCKWORK_VIEWS_USE_TWIG_PROFILER', false),
        ],

    ],

    /*
    |-----------------------------------------------------------------------
    | Enable web UI
    |-----------------------------------------------------------------------
    |
    | Clockwork comes with a web UI accessible via http://your.app/clockwork.
    | Here you can enable or disable this feature. You can also set a custom
    | path for the web UI.
    |
    */

    'web' => env('CLOCKWORK_WEB', true),

    /*
    |-----------------------------------------------------------------------
    | Enable toolbar
    |-----------------------------------------------------------------------
    |
    | Clockwork can show a toolbar with basic metrics on all responses.
    | Here you can enable or disable this feature. Requires a separate
    | clockwork-browser npm library.
    |
    */

    'toolbar' => env('CLOCKWORK_TOOLBAR', false),

    /*
    |-----------------------------------------------------------------------
    | HTTP requests collection
    |-----------------------------------------------------------------------
    |
    | Clockwork collects data about HTTP requests to your app. Here you can
    | choose which requests should be collected.
    |
    */

    'requests' => [
        'on_demand'        => env('CLOCKWORK_REQUESTS_ON_DEMAND', false),
        'errors_only'      => env('CLOCKWORK_REQUESTS_ERRORS_ONLY', false),
        'slow_threshold'   => env('CLOCKWORK_REQUESTS_SLOW_THRESHOLD'),
        'slow_only'        => env('CLOCKWORK_REQUESTS_SLOW_ONLY', false),
        'sample'           => env('CLOCKWORK_REQUESTS_SAMPLE', false),
        'except'           => ['/horizon/.*', '/telescope/.*', '/_debugbar/.*'],
        'only'             => [],
        'except_preflight' => env('CLOCKWORK_REQUESTS_EXCEPT_PREFLIGHT', true),
    ],

    /*
    |-----------------------------------------------------------------------
    | Artisan commands collection
    |-----------------------------------------------------------------------
    |
    | Clockwork can collect data about executed artisan commands. Here you
    | can enable and configure which commands should be collected.
    |
    */

    'artisan' => [
        'collect'                 => env('CLOCKWORK_ARTISAN_COLLECT', false),
        'except'                  => [],
        'only'                    => [],
        'collect_output'          => env('CLOCKWORK_ARTISAN_COLLECT_OUTPUT', false),
        'except_laravel_commands' => env('CLOCKWORK_ARTISAN_EXCEPT_LARAVEL_COMMANDS', true),
    ],

    /*
    |-----------------------------------------------------------------------
    | Queue jobs collection
    |-----------------------------------------------------------------------
    |
    | Clockwork can collect data about executed queue jobs. Here you can
    | enable and configure which queue jobs should be collected.
    |
    */

    'queue' => [
        'collect' => env('CLOCKWORK_QUEUE_COLLECT', false),
        'except'  => [],
        'only'    => [],
    ],

    /*
    |-----------------------------------------------------------------------
    | Tests collection
    |-----------------------------------------------------------------------
    |
    | Clockwork can collect data about executed tests. Here you can enable
    | and configure which tests should be collected.
    |
    */

    'tests' => [
        'collect' => env('CLOCKWORK_TESTS_COLLECT', false),
        'except'  => [],
    ],

    /*
    |-----------------------------------------------------------------------
    | Enable data collection when Clockwork is disabled
    |-----------------------------------------------------------------------
    |
    | You can enable this setting to collect data even when Clockwork is
    | disabled, e.g. for future analysis.
    |
    */

    'collect_data_always' => env('CLOCKWORK_COLLECT_DATA_ALWAYS', false),

    /*
    |-----------------------------------------------------------------------
    | Metadata storage
    |-----------------------------------------------------------------------
    |
    | Configure how is the metadata collected by Clockwork stored. Two
    | options are available:
    |
    |   - files - Storing data in one-per-request files.
    |   - sql - Stores requests in a sql database.
    |
    */

    'storage'                => env('CLOCKWORK_STORAGE', 'files'),
    'storage_files_path'     => env('CLOCKWORK_STORAGE_FILES_PATH', storage_path('framework/clockwork')),
    'storage_files_compress' => env('CLOCKWORK_STORAGE_FILES_COMPRESS', false),
    'storage_sql_database'   => env('CLOCKWORK_STORAGE_SQL_DATABASE', storage_path('clockwork.sqlite')),
    'storage_sql_table'      => env('CLOCKWORK_STORAGE_SQL_TABLE', 'clockwork'),
    'storage_expiration'     => env('CLOCKWORK_STORAGE_EXPIRATION', 2),

    /*
    |-----------------------------------------------------------------------
    | Authentication
    |-----------------------------------------------------------------------
    |
    | Clockwork can be configured to require authentication before allowing
    | access to the collected data. This might be useful when the application
    | is publicly accessible. Setting to true will enable a simple
    | authentication with a pre-configured password. You can also pass a
    | class name of a custom implementation.
    |
    */

    'authentication'          => env('CLOCKWORK_AUTHENTICATION', false),
    'authentication_password' => env('CLOCKWORK_AUTHENTICATION_PASSWORD', 'VerySecretPassword'),

    /*
    |-----------------------------------------------------------------------
    | Stack traces collection
    |-----------------------------------------------------------------------
    |
    | Clockwork can collect stack traces for log messages and certain data
    | like database queries. Here you can set whether to collect stack
    | traces, limit the number of collected frames and set further
    | configuration. Collecting long stack traces considerably
    | increases metadata size.
    |
    */

    'stack_traces' => [
        'enabled'         => env('CLOCKWORK_STACK_TRACES_ENABLED', true),
        'limit'           => env('CLOCKWORK_STACK_TRACES_LIMIT', 10),
        'skip_vendors'    => [],
        'skip_namespaces' => [],
        'skip_classes'    => [],
    ],

    /*
    |-----------------------------------------------------------------------
    | Serialization
    |-----------------------------------------------------------------------
    |
    | Clockwork serializes the collected data to json for storage and
    | transfer. Here you can configure certain aspects of serialization.
    | Serialization has a large effect on the cpu time and memory usage.
    |
    */

    'serialization_depth'    => env('CLOCKWORK_SERIALIZATION_DEPTH', 10),
    'serialization_blackbox' => [
        \Illuminate\Container\Container::class,
        \Illuminate\Foundation\Application::class,
        \Laravel\Lumen\Application::class,
    ],

    /*
    |-----------------------------------------------------------------------
    | Register helpers
    |-----------------------------------------------------------------------
    |
    | Clockwork comes with a "clock" global helper function. You can use
    | this helper to quickly log something and to access the instance.
    |
    */

    'register_helpers' => env('CLOCKWORK_REGISTER_HELPERS', true),

    /*
    |-----------------------------------------------------------------------
    | Send headers for AJAX request
    |-----------------------------------------------------------------------
    |
    | When trying to collect data, the AJAX method can sometimes fail if it
    | is missing required headers. For example, an API might require a
    | version number using Accept headers to route the HTTP request
    | to the correct codebase.
    |
    */

    'headers' => [],

    /*
    |-----------------------------------------------------------------------
    | Server timing
    |-----------------------------------------------------------------------
    |
    | Clockwork supports the W3C Server Timing specification, which allows
    | for collecting a simple performance metrics in a cross-browser way.
    | E.g. in Chrome, your app, database and timeline event timings will
    | be shown in the Dev Tools network tab. This setting specifies the
    | max number of timeline events that will be sent. Setting to false
    | will disable the feature.
    |
    */

    'server_timing' => env('CLOCKWORK_SERVER_TIMING', 10),

];
