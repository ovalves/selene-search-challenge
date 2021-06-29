<?php

use Selene\Config\ConfigConstant;
use Selene\Database\DatabaseConstant;

return [
    ConfigConstant::DATABASE => [
        'mysql' => [
            DatabaseConstant::DB_HOST => 'localhost',
            DatabaseConstant::DB_NAME => "test",
            DatabaseConstant::DB_USER => "root",
            DatabaseConstant::DB_PASS => "root",
        ],
        DatabaseConstant::DEFAULT_DB => 'mysql',
    ]
];