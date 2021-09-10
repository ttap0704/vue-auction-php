<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserCashChargerRepository
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
    public function updateCash(array $user): array
    {
        $row = [
            'id' => $user['id'],
            'cash' => $user['cash'],
        ];

        $sql = "UPDATE users SET cash = :cash WHERE id = :id";
                

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $row['id']);
        $stmt->bindParam(':cash', $row['cash']);
        $status = $stmt->execute();

        if ($status) {
          $res['pass'] = true;
        } else {
          $res['pass'] = false;
        }

        return (array)$res;
    }
}
