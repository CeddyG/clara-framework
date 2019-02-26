<?php

/**
 * Default config values
 */
return [
    
    'route-admin' => [
        'web-admin' => [
            'prefix'    => 'admin',
            'middleware' => ['web', \CeddyG\Clara\Http\Middleware\SentinelAccessMiddleware::class]
        ],
        'api' => [
            'prefix'    => 'api/admin',
            'middleware' => ['api', \CeddyG\Clara\Http\Middleware\SentinelAccessMiddleware::class.':api']
        ]
    ],
    
];
