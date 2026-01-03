<?php

return [

    'defaults' => [
        'guard' => 'web',  // default can be 'web' or 'client'
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'client' => [
            'driver' => 'session',
            'provider' => 'clients',
        ],

        'business' => [
            'driver' => 'session',
            'provider' => 'business_users',
        ],

        'worker' => [
            'driver' => 'session',
            'provider' => 'workers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // clients are in users table
        ],

        'business_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // business owners in users table
        ],

        'workers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Worker\Worker::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'clients' => [
            'provider' => 'clients',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],

        'business' => [
            'provider' => 'business_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],

        'workers' => [
            'provider' => 'workers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
