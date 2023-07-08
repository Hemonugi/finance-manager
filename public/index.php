<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Hemonugi\FinanceManager\Account\AccountController;
use Hemonugi\FinanceManager\Swagger\SwaggerController;
use Middlewares\TrailingSlash;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../configs/settings.php');
$container = $builder->build();

$container->set(EntityManager::class, static function (ContainerInterface $container): EntityManager {
    /** @var array $settings */
    $settings = $container->get('settings')['doctrine'];
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: $settings['metadata_dirs'],
        isDevMode: $settings['dev_mode'],
    );
    $connection = DriverManager::getConnection($settings['connection'], $config);

    return new EntityManager($connection, $config);
});

$app = Bridge::create($container);
$app->add((new TrailingSlash(true))->redirect());

$app->get('/api/doc/config/', [SwaggerController::class, 'config']);
$app->get('/api/doc/', [SwaggerController::class, 'view']);
$app->get('/api/account/', [AccountController::class, 'balance']);

$app->addErrorMiddleware(true, true, true);

$app->run();
