<?php

declare(strict_types=1);

namespace Experiment\NewSystem\Entity\Application\UpdateEntity;

use Experiment\NewSystem\Entity\Domain\Entity;
use Experiment\NewSystem\Entity\Domain\EntityRepositoryInterface;
use Experiment\NewSystem\Entity\Domain\EntityReadRepositoryInterface;

final class UpdateEntityHandler
{
    private $entityReadRepository;
    private $entityRepository;

    public function __construct(
        EntityReadRepositoryInterface $entityReadRepository,
        EntityRepositoryInterface $entityWriteRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->entityReadRepository = $entityReadRepository;
    }

    public function handle(UpdateEntityCommand $command, int $entityId): Entity
    {
        $this->command = $command; 
        $entity = $this->entityReadRepository->findById($entityId);
        

       $entity->update(
        $this->commandHasData('firstName') ? $command->firstName() : $entity->firstName(),
        $this->commandHasData('lastName') ? $command->lastName() : $entity->lastName(),
        $this->commandHasData('email') ? $command->email() : $entity->email(),
        $this->commandHasData('age') ? $command->age() : $entity->age(),
        $this->commandHasData('experimentId') ? $command->experimentId() : $entity->experimentId()
       );
        
        $this->entityRepository->updateEntity($entity, $entityId);

        return $entity;
    }

    public function commandHasData(string $data): bool
    {
        return property_exists($this->command, $data) || $data !== null;
    }
}
