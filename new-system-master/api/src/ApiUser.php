<?php

declare(strict_types=1);

namespace Experiment\NewSystem;

use Doctrine\DBAL\Driver\OCI8\OCI8Connection;
use Fence\Frapi\Users\KeycloakUser;

class ApiUser extends KeycloakUser
{
    protected $id;
    private $connection;

    public function __construct(\stdClass $token)
    {
        parent::__construct($token);
        $this->connection = new OCI8Connection(
            getenv("DB_USERNAME"),
            getenv("DB_PASSWORD"),
            getenv("DB_DNS")
        );
        $this->id = $this->getIdFromDatabase();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdFromDatabase()
    {
        $query = "SELECT ID FROM EXPERIMENT_GLANCE.GLOBAL_USER WHERE CCID = :varPersonId";
        $statement = $this->connection->prepare($query);
        $binds = ["varPersonId" => $this->getPersonId()];
        $statement->execute($binds);
        $rows = $statement->fetchAll();
        return (int) $rows[0]["ID"];
    }
}
