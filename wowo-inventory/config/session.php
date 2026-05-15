<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used to
    | manage user sessions across requests. By default, we will use the
    | lightweight native driver, but you may specify any session store.
    |
    | Supported: "array", "cookie", "database", "file",
    |            "memcached", "redis"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them
    | to immediately expire on the browser closing, set that option.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it is stored. All encryption will be run
    | automatically by Laravel and you can use the Session like normal.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When using the native session driver, we need a location where session
    | files may be stored. A default has been set for you but a different
    | location may be specified. This is only needed for file sessions.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond with a connection in your database configuration options.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table we
    | should use to manage the sessions. Of course, a sensible default is
    | provided for you; however, you are free to change this as needed.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using the "apc" or "dynamodb" session drivers, you may specify a
    | cache store that should be used for these sessions. This value must
    | correspond with one of your defined cache stores / connections.
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must sweep their storage location periodically to
    | delete expired sessions from storage. Here are the chances that the
    | garbage collection process will occur on a given request. By default
    | the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Settings
    |--------------------------------------------------------------------------
    |
    | Here you may change the properties of the cookie that is used to
    | hold the session identifier. The secure option should be set to
    | true if you are running over HTTPS to avoid transmission of the
    | cookie unencrypted through the wire.
    |
    */

    'cookie' => [
        'name' => env('SESSION_COOKIE', Illuminate\Support\Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),
        'path' => '/',
        'domain' => env('SESSION_DOMAIN'),
        'secure' => env('SESSION_SECURE_COOKIES', false),
        'http_only' => true,
        'same_site' => 'lax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie SameSite
    |--------------------------------------------------------------------------
    |
    | Configure the SameSite attribute of the session cookie. This value may
    | be: 'lax', 'strict', 'none', or false. Please note that false is not a
    | valid SameSite attribute, false should only be used to disable the feature.
    |
    */

    'same_site' => 'lax',

];
