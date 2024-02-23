<?php

namespace Experiment\NewSystem\Entity\Application\GetEntityDetails;

interface EntityViewRepositoryInterface
{
    /** @return Entity[] */
    public function findAllEntities(): array;

    public function findById(int $entityId): ?Entity;
}
