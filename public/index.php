<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Hemonugi\FinanceManager\Account\AccountController;
use Hemonugi\FinanceManager\Database;
use Hemonugi\FinanceManager\Swagger\SwaggerController;
use Middlewares\TrailingSlash;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../configs/settings.php');
$container = $builder->build();

$container->set(Database::class, static function (ContainerInterface $container): Database {
    /** @var string[] $settings */
    $settings = $container->get('db');
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
        $settings['host'],
        $settings['port'],
        $settings['dbname'],
        $settings['user'],
        $settings['password'],
    );

    return new Database(new PDO($dsn));
});

$app = Bridge::create($container);
$app->add((new TrailingSlash(true))->redirect());

$app->get('/api/doc/config/', [SwaggerController::class, 'config']);
$app->get('/api/doc/', [SwaggerController::class, 'view']);
$app->get('/api/account/', [AccountController::class, 'balance']);

$app->addErrorMiddleware(true, true, true);

$app->run();
