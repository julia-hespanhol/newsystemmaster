<?php

namespace Experiment\NewSystem\Entity\Domain;

interface EntityRepositoryInterface
{
    public function findNextEntityId(): int;

    public function registerEntity(Entity $entity, int $agentId): void;

    public function updateEntity(Entity $entity, int $agentId): void;
}
