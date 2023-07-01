<?php

declare(strict_types=1);

use Hemonugi\FinanceManager\Account\AccountController;
use Middlewares\TrailingSlash;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->add((new TrailingSlash(true))->redirect());

$app->get('/api/account/', [new AccountController(), 'balance']);

$app->addErrorMiddleware(true, true, true);

$app->run();
