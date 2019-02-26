<?php

/**
 * Default config values
 */
return [
    
    'route-admin' => [
        'web-admin' => [
            'prefix'    => 'admin',
            'middleware' => ['web', 'access']
        ],
        'api' => [
            'prefix'    => 'api/admin',
            'middleware' => ['api', 'access']
        ]
    ],
    
];
