<?php

declare(strict_types=1);


namespace Glance\Onboarding\Collaboration\Infrastructure\Persistence;

use Doctrine\DBAL\Driver\Connection;
use Glance\Onboarding\Collaboration\Application\GetEntityDetails\EntityViewRepositoryInterface;
use Glance\Onboarding\Collaboration\Application\GetEntityDetails\Entity as  EntityDetails;
use Glance\Onboarding\Collaboration\Domain\Entity;
use Glance\Onboarding\Collaboration\Domain\EntityReadRepositoryInterface;
use Glance\Onboarding\Collaboration\Domain\ EntityRepositoryInterface;

class SqlMemberRepository implements
    EntityViewRepositoryInterface,
    EntityReadRepositoryInterface,
    EntityRepositoryInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findNextEntityId(): int
    {
        $query = "SELECT MAX(ID) + 1 AS NEXT_ID FROM MEMBER";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return (int) $statement->fetchOne();
    }

    public function findAllEntities(): array
    {
        $query = "SELECT
                M.ID AS ID,
                M.FIRST_NAME AS FIRST_NAME,
                M.LAST_NAME AS LAST_NAME,
                M.EMAIL AS EMAIL,
                M.AGE AS AGE,
                M.EXPERIMENT_ID AS EXPERIMENT_ID
            FROM MEMBER AS M
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return array_map(function (array $row) {
            return  EntityDetails::fromPersistence($row);
        }, $statement->fetchAllAssociative());
    }

    public function findDetailsById(int $id): ?EntityDetails
    {
        $query = "SELECT
                M.ID AS ID,
                M.FIRST_NAME AS FIRST_NAME,
                M.LAST_NAME AS LAST_NAME,
                M.EMAIL AS EMAIL,
                M.AGE AS AGE,
                M.EXPERIMENT_ID AS EXPERIMENT_ID
            FROM MEMBER AS M
            WHERE M.ID = :id
        ";
        $statement = $this->connection->prepare($query);
        $payload = [
            'id' => $id
        ];
        $statement->execute($payload);
        $rows = $statement->fetchAllAssociative();

        return $rows ?  EntityDetails::fromPersistence($rows[0]) : null;
    }

    public function findById(int $id): Entity
    {
        $query = "SELECT M.ID AS ID,
            M.FIRST_NAME AS FIRST_NAME,
            M.LAST_NAME AS LAST_NAME,
            M.EMAIL AS EMAIL,
            M.AGE AS AGE,
            M.EXPERIMENT_ID AS EXPERIMENT_ID
            FROM MEMBER AS M
            WHERE M.ID = :id
         ";
        
        $statement = $this->connection->prepare($query);
        
        $payload = [
            'id' => $id
        ];
        
        $statement->execute($payload);
        $rows = $statement->fetchAllAssociative();

        return Member::fromPersistence($rows[0]);
    }

    public function registerEntity(Entity $entity): void
    {
        $query = "INSERT
            INTO MEMBER (
                ID,
                FIRST_NAME,
                LAST_NAME,
                EMAIL,
                AGE,
                EXPERIMENT_ID
            ) VALUES (
                :id,
                :firstName,
                :lastName,
                :email,
                :age,
                :experimentId
            )
        ";
        $statement = $this->connection->prepare($query);
        $payload = [
            'id' => $entity->id()->toInteger(),
            'firstName' => $entity->firstName(),
            'lastName' => $entity->lastName(),
            'email' => $entity->email(),
            'age' => $entity->age(),
            'experimentId' => $entity->experimentId()
        ];
        $statement->execute($payload);
    }

    //Atualização de Membros

    public function updateEntity(Entity $entity, int $id): void
    {
        $query = "UPDATE MEMBER AS M
        SET     
            M.FIRST_NAME = :firstName,
            M.LAST_NAME = :lastName,
            M.EMAIL = :email,
            M.AGE = :age,
            M.EXPERIMENT_ID = :experimentId

        WHERE M.ID = :id
        ";

        $statement = $this->connection->prepare($query);

        $payload = [
            'id' => $id,
            'firstName' => $member->firstName(),
            'lastName' => $member->lastName(),
            'email' => $member->email(),
            'age' => $member->age(),
            'experimentId' => $member->experimentId()
        ];

        $statement->execute($payload);
    }

    public function deleteEntity(int $id): void
    {
        $query = "DELETE FROM MEMBER  
                   WHERE ID = :id
        ";

        $statement = $this->connection->prepare($query);

        $payload = [
            'id' => $id
        ];

        $statement->execute($payload);
        
        //$sucess = $statement->execute($payload);

        //return $sucess;
    }
}