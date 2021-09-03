<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserLoginRepository
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
   * @return array The new ID
   */
  public function checkUser(array $user): array
  {
    $row = [
      'email' => $user['email'],
      'password' => $user['password'],
    ];

    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':email', $row['email']);
    $stmt->bindParam(':password', $row['password']);
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res) {
      $res['pass'] = true;
    } else {
      $res['pass'] = false;
    }

    return (array) $res;
  }
}
