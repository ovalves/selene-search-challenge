<?php

use Selene\Config\ConfigConstant;
use Selene\Database\DatabaseConstant;

return [
    ConfigConstant::DATABASE => [
        'mysql' => [
            DatabaseConstant::DB_HOST => env('MYSQL_HOST'),
            DatabaseConstant::DB_NAME => env('MYSQL_DATABASE'),
            DatabaseConstant::DB_USER => env('MYSQL_USER'),
            DatabaseConstant::DB_PASS => env('MYSQL_PASSWORD'),
        ],
        DatabaseConstant::DEFAULT_DB => 'mysql',
    ],
    'ENABLE_SESSION_CONTAINER' => false,
    'ENABLE_AUTH_CONTAINER' => false,
];
