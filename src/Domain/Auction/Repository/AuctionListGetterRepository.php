<?php

namespace App\Domain\Auction\Repository;

use PDO;


/**
 * Repository.
 */
class AuctionListGetterRepository
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
  public function checkDetail(): array
  {
    $row = [];
    // $sql = "SELECT *, auctions.id AS id, auctions.created_at AS created_at
    // FROM auctions 
    // LEFT JOIN users on auctions.host_id = users.id 
    // ORDER BY auctions.created_at DESC LIMIT 20";


    // $stmt = $this->connection->prepare($sql);
    // $stmt->execute();
    // $res = $stmt->fetch();

    // $row = [];
    // $row["id"] = $res["id"];
    // $row["content"] = $res["content"];
    // $row["title"] = $res["title"];
    // $row["created_at"] = $res["created_at"];
    // $row["uid"] = $res["writer"];
    // $row["unick"] = $res["nick"];

    return (array) $row;
  }
}
