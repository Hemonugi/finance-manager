<?php

declare(strict_types=1);

const APP_ROOT = __DIR__ . "/..";

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

return [
    'db' => [
        'driver' => 'pdo_pgsql',
        'host' => $_ENV['POSTGRES_HOST'],
        'port' => $_ENV['POSTGRES_PORT'],
        'dbname' => $_ENV['POSTGRES_DB'],
        'user' => $_ENV['POSTGRES_USER'],
        'password' => $_ENV['POSTGRES_PASSWORD'],
        'charset' => 'utf-8',
    ],
];
