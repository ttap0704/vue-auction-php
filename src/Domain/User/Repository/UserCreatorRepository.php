<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserCreatorRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert user row.
     *
     * @param array<mixed> $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'nick' => $user['nick'],
        ];

        $sql = "INSERT INTO users SET 
                name=:name, 
                email=:email, 
                password=:password, 
                nick=:nick;";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':name', $row['name']);
        $stmt->bindParam(':email', $row['email']);
        $stmt->bindParam(':password', $row['password']);
        $stmt->bindParam(':nick', $row['nick']);
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }
}
