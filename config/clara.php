<?php

/**
 * Default config values
 */
return [
    
    'route-admin' => [
        'web-admin' => [
            'namespace'     => 'App\Http\Controllers\Admin',
            'prefix'        => 'admin',
            'middleware'    => ['web', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class]
        ],
        'api' => [
            'namespace'     => 'App\Http\Controllers\Admin',
            'prefix'        => 'api/admin',
            'middleware'    => ['api', \CeddyG\ClaraSentinel\Http\Middleware\SentinelAccessMiddleware::class.':api']
        ]
    ],
    
];
