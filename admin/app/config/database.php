<?php
return [

    'fetch' => PDO::FETCH_CLASS,

    'default' => 'global',

    'connections' => [

        'global' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'zbond_pionner',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],

    'migrations' => 'migrations',

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ]
    ]
];
