<?php

declare(strict_types=1);

namespace Experiment\NewSystem\Entity\Infrastructure\Web;

use Fence\Frapi\Api;
use Fence\Frapi\Errors\BaseError;
use Fence\Frapi\Exceptions\BaseException;
use Fence\Frapi\Http\StatusCodes;
use Experiment\NewSystem\Entity\Application\GetEntityDetails\EntityViewRepositoryInterface;
use Experiment\NewSystem\Entity\Application\RegisterEntity\RegisterEntityCommand;
use Experiment\NewSystem\Entity\Application\RegisterEntity\RegisterEntityHandler;
use Experiment\NewSystem\Entity\Application\UpdateEntity\UpdateEntityCommand;
use Experiment\NewSystem\Entity\Application\UpdateEntity\UpdateEntityHandler;
use Psr\Http\Message\ResponseInterface;

class EntityController
{
    private $registerEntityHandler;
    private $entityViewRepository;
    private $updateEntityHandler;

    public function __construct(
        RegisterEntityHandler $registerEntityHandler,
        EntityViewRepositoryInterface $entityViewRepository,
        UpdateEntityHandler $updateEntityHandler
    ) {
        $this->registerEntityHandler = $registerEntityHandler;
        $this->entityViewRepository = $entityViewRepository;
        $this->updateEntityHandler = $updateEntityHandler;
    }

    public function findEntity(Api $api, int $entityId): ResponseInterface
    {
        $responseBody = json_encode(["entity" => $this->entityViewRepository->findById($entityId)]);
        $response = $api->getResponse();
        $response->getBody()->write($responseBody);
        return $response->withHeader("content-type", "application/json");
    }

    public function findAllEntities(Api $api): ResponseInterface
    {
        $responseBody = json_encode(["entities" => $this->entityViewRepository->findAllEntities()]);
        $response = $api->getResponse();
        $response->getBody()->write($responseBody);
        return $response->withHeader("content-type", "application/json");
    }

    public function registerEntity(Api $api): ResponseInterface
    {
        $input = $api->getRequest()->getBodyAsArray();
        $agentId = (int) $api->getUser()->getId();

        $command = RegisterEntityCommand::fromHttpRequest($input["entity"], $agentId);
        try {
            $entity = $this->registerEntityHandler->handle($command);
        } catch (\InvalidArgumentException $e) {
            $this->throwForbiddenException($e->getMessage());
        } catch (\DomainException $e) {
            $this->throwForbiddenException($e->getMessage());
        }

        $responseBody = json_encode(["entity" => $this->entityViewRepository->findById($entity->id())]);
        $response = $api->getResponse();
        $response->getBody()->write($responseBody);
        return $response->withHeader("content-type", "application/json");
    }

    public function updateEntity(Api $api, int $entityId): ResponseInterface
    {
        $input = $api->getRequest()->getBodyAsArray();
        $agentId = (int) $api->getUser()->getId();

        $command = UpdateEntityCommand::fromHttpRequest($input["entity"], $entityId, $agentId);
        try {
            $entity = $this->updateEntityHandler->handle($command);
        } catch (\InvalidArgumentException $e) {
            $this->throwForbiddenException($e->getMessage());
        } catch (\DomainException $e) {
            $this->throwForbiddenException($e->getMessage());
        }

        $responseBody = json_encode(["entity" => $this->entityViewRepository->findById($entity->id())]);
        $response = $api->getResponse();
        $response->getBody()->write($responseBody);
        return $response->withHeader("content-type", "application/json");
    }

    private function throwForbiddenException(string $exceptionDetails): void
    {
        $error = new BaseError();
        $error->setTitle("Action forbidden.")
        ->setStatus(StatusCodes::HTTP_BAD_REQUEST)
            ->setDetail($exceptionDetails);

        throw new BaseException(
            StatusCodes::HTTP_BAD_REQUEST,
            [$error]
        );
    }
}
