<?php

namespace App\Domain\Auction\Repository;

use PDO;

/**
 * Repository.
 */
class AuctionDetailGetterRepository
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
  public function checkDetail($data): array
  {
    $row = [];

    $hashtag = $data['hashtag'];

    // $sql = "SELECT *, auctions.id AS id, auctions.created_at AS created_at
    // FROM auctions 
    // LEFT JOIN users ON auctions.host_id = users.id 
    // WHERE auctions.id = :id
    // ORDER BY auctions.created_at DESC LIMIT 20";


    // $stmt = $this->connection->prepare($sql);
    // $stmt->bindParam(':id', $aid);
    // $stmt->execute();
    // $res = $stmt->fetch();

    $row['test'] = $this->checkHashtag($hashtag);

    return (array) $row;
  }

  public function checkHashtag(string $hashtag)
  {
    // $row = [];
    $sql = "SELECT id FROM hashtags WHERE hashtag LIKE '%$hashtag%'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }
}
