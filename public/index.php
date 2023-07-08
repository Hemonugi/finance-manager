<?php

declare(strict_types=1);

use Hemonugi\FinanceManager\Account\AccountController;
use Hemonugi\FinanceManager\Swagger\SwaggerController;
use Middlewares\TrailingSlash;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->add((new TrailingSlash(true))->redirect());

$app->get('/api/doc/config/', [new SwaggerController(), 'config']);
$app->get('/api/doc/', [new SwaggerController(), 'view']);
$app->get('/api/account/', [new AccountController(), 'balance']);

$app->addErrorMiddleware(true, true, true);

$app->run();
