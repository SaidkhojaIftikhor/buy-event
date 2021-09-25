<?php


namespace app;

use core\DB;

class ClientRepository
{
    private \PDO $connection;

    /**
     * ClientRepository constructor.
     */
    public function __construct()
    {
        $this->connection = (new DB())->connect();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {

        $query = "SELECT id, name, email, phone_number from clients";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id): array
    {
        $query = "SELECT name, email, phone_number, orders.price, orders.product from clients INNER JOIN orders ON clients.id = orders.client_id WHERE clients.id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }
}
