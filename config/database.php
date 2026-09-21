<?php

use Illuminate\Support\Str;

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST') ?: 'sql310.infinityfree.com',
            'port' => env('DB_PORT') ?: '3306',
            'database' => env('DB_DATABASE') ?: 'if0_42971738_furshield',
            'username' => env('DB_USERNAME') ?: 'if0_42971738',
            'password' => env('DB_PASSWORD') ?: 'Evw88q4GNan7',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::ATTR_EMULATE_PREPARES => false,
            ]) : [],
        ],
    ],
];
