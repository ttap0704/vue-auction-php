<?php

namespace App\Domain\Comunity\Repository;

use PDO;

/**
 * Repository.
 */
class PostCreatorRepository
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
    public function insertUser(array $post): int
    {
        $row = [
            'title' => $post['title'],
            'content' => $post['content'],
            'writer' => $post['writer'],
        ];

        $sql = "INSERT INTO posts SET 
                title=:title, 
                content=:content, 
                writer=:writer;"; 

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $row['title']);
        $stmt->bindParam(':content', $row['content']);
        $stmt->bindParam(':writer', $row['writer']);
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }
}
