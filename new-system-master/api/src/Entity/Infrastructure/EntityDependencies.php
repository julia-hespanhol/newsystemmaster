<?php

declare(strict_types=1);

namespace Experiment\NewSystem\Entity\Infrastructure;

use Doctrine\DBAL\Driver\Connection;
use Experiment\NewSystem\Entity\Application\GetEntityDetails\EntityViewRepositoryInterface;
use Experiment\NewSystem\Entity\Domain\EntityRepositoryInterface;
use Experiment\NewSystem\Entity\Domain\EntityReadRepositoryInterface;
use Experiment\NewSystem\Entity\Infrastructure\Persistence\SqlEntityReadRepository;
use Experiment\NewSystem\Entity\Infrastructure\Persistence\SqlEntityRepository;
use Experiment\NewSystem\Entity\Infrastructure\Persistence\SqlEntityViewRepository;

abstract class EntityDependencies
{
    public static function definitions(): array
    {
        return [
            EntityViewRepositoryInterface::class => function (Connection $connection) {
                return new SqlEntityViewRepository($connection);
            },
            EntityReadRepositoryInterface::class => function (Connection $connection) {
                return new SqlEntityReadRepository($connection);
            },
            EntityRepositoryInterface::class => function (Connection $connection) {
                return new SqlEntityRepository($connection);
            },
        ];
    }
}
