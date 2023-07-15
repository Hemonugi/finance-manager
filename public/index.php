<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Hemonugi\FinanceManager\Account\AccountController;
use Hemonugi\FinanceManager\Swagger\SwaggerController;
use Middlewares\TrailingSlash;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../configs/settings.php');
$container = $builder->build();

$app = Bridge::create($container);
$app->add((new TrailingSlash(true))->redirect());

$app->get('/api/doc/config/', [SwaggerController::class, 'config']);
$app->get('/api/doc/', [SwaggerController::class, 'view']);
$app->get('/api/account/', [AccountController::class, 'balance']);

$app->addErrorMiddleware(true, true, true);

$app->run();
