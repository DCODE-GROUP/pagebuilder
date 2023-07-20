<?php

return [
    'routing' => [
        'admin' => [
            'middlewares' => [],

            'prefix' => '',

            'name_prefix' => '',
        ],

        'front' => [
            'middlewares' => [],

            'prefix' => '/',

            'name_prefix' => 'cms.',
        ],
    ],
    'media' => [
        'conversions' => [
            'thumb' => [
                'width' => 150,
                'height' => 150,
            ],
            'list' => [
                'width' => 150,
                'height' => 150,
            ],
            'grid' => [
                'width' => 150,
                'height' => 150,
            ],
        ]
    ],
];
