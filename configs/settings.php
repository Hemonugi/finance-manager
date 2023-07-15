<?php

declare(strict_types=1);

const APP_ROOT = __DIR__ . "/..";

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

return [
    'db' => [
        'driver' => 'pdo_pgsql',
        'host' => 'database',
        'port' => 5432,
        'dbname' => $_ENV['POSTGRES_DB'],
        'user' => $_ENV['POSTGRES_USER'],
        'password' => $_ENV['POSTGRES_PASSWORD'],
        'charset' => 'utf-8',
    ],
];
