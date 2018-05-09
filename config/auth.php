<?php

return [

    // Default paths
    'app' => [
        'login' => '/login',
        'home'  => '/users'
    ],
    
    // Default Auth Settings
    'defaults' => [
        'guard'     => 'app',
        'passwords' => 'app_users',
    ],
   
    // Guards
    'guards' => [
        'app' => [
            'driver'    => 'session',
            'provider'  => 'app_users',
        ]
    ],
    
    'providers' => [
        'app_users' => [
            'driver'    => 'eloquent',
            'model'     => App\Resources\Entities\User::class,
        ]
    ],

    'passwords' => [
        'app_users' => [
            'provider'  => 'app_users',
            'table'     => 'um_password_resets',
            'expire'    => 60,
        ]
    ]
];
