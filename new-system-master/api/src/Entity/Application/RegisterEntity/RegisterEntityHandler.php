<?php

declare(strict_types=1);

namespace Experiment\NewSystem\Entity\Application\RegisterEntity;

use Experiment\NewSystem\Entity\Domain\Entity;
use Experiment\NewSystem\Entity\Domain\EntityRepositoryInterface;

final class RegisterEntityHandler
{
    
    private $entityRepository;


    public function __construct(
        EntityRepositoryInterface $entityRepository
    ) {
        $this->entityRepository = $entityWriteRepository;
    }

    public function handle(Register EntityCommand $command): Entity
    {
        $id = new IntegerId(
            $this->entityReadRepository->findNextEntityId()
        );

        $member = Entity::create(
            $id,
            $command->firstName(),
            $command->lastName(),
            $command->email(),
            $command->age(),
            $command->experimentId()
        );

        $this->entityrWriteRepository->registerEntity($entity);

        return $entity;
    }
}
