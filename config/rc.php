<?php

return [
    'ok' => [
        'rc' => '200',
        'message' => 'OK',
        'data' => false
    ],
    'bad_request' => [
        'rc' => '400',
        'message' => 'Bad Request',
        'data' => false
    ],
    'unauthorized' => [
        'rc' => '401',
        'message' => 'Unauthorized',
        'data' => false
    ],
    'not_found' => [
        'rc' => '404',
        'message' => 'Not Found',
        'data' => false
    ],
    'too_many_requests' => [
        'rc' => '429',
        'message' => 'Too Many Attempts',
        'data' => false
    ]
];
