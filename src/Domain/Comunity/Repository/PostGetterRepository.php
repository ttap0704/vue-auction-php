<?php

namespace App\Domain\Comunity\Repository;

use PDO;


/**
 * Repository.
 */
class PostGetterRepository
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
  public function checkPosts(): array
  {
    $sql = "SELECT *, posts.id AS id, posts.created_at AS created_at
        FROM posts 
        LEFT JOIN users on posts.writer = users.id 
        ORDER BY posts.created_at DESC LIMIT 20";


    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll();

    $rows = [];
    for ($i = 0, $leng = count($res); $i < $leng; $i++) {
      $rows[$i]["id"] = $res[$i]["id"];
      $rows[$i]["content"] = $res[$i]["content"];
      $rows[$i]["title"] = $res[$i]["title"];
      $rows[$i]["created_at"] = $res[$i]["created_at"];
      $rows[$i]["uid"] = $res[$i]["writer"];
      $rows[$i]["unick"] = $res[$i]["nick"];
    }

    return (array) $rows;
  }
}
