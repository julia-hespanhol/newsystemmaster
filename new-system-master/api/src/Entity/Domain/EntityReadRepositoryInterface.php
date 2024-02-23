<?php

namespace Experiment\NewSystem\Entity\Domain;

interface EntityReadRepositoryInterface
{
    public function findById(int $figureId): ?Entity;
}
