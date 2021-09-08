<?php

namespace App\Domain\Comunity\Repository;

use PDO;


/**
 * Repository.
 */
class PostDetailGetterRepository
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
  public function checkDetail($pid): array
  {

    $sql = "SELECT *, posts.id AS id, posts.created_at AS created_at
        FROM posts
        LEFT JOIN users on posts.writer = users.id
        WHERE posts.id = :pid";


    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(":pid", $pid);
    $stmt->execute();
    $res = $stmt->fetch();

    $row = [];
    $row["id"] = $res["id"];
    $row["content"] = $res["content"];
    $row["title"] = $res["title"];
    $row["created_at"] = $res["created_at"];
    $row["uid"] = $res["writer"];
    $row["unick"] = $res["nick"];

    return (array) $row;
  }
}
