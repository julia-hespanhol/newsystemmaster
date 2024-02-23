<?php

declare(strict_types=1);

require "vendor/autoload.php";

use Fence\Frapi\Api;
use DI\ContainerBuilder;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\OCI8\OCI8Connection;
use LHCb\ALCM\Figure\Infrastructure\FigureDependencies;

$api = new Api("configuration/api.json");
$containerBuilder = new ContainerBuilder();

$baseDefinitions = [
    Connection::class => function () {
        $connection = new OCI8Connection(
            getenv("DB_USERNAME"),
            getenv("DB_PASSWORD"),
            getenv("DB_DNS")
        );
        return $connection;
    }
];

$containerBuilder->addDefinitions(
    array_merge(
        $baseDefinitions,
        FigureDependencies::definitions(),
    )
);

$container = $containerBuilder->build();
$api->setContainer($container);
$api->run();
