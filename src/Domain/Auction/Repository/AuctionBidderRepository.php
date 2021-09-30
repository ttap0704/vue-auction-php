<?php

namespace App\Domain\Auction\Repository;

use PDO;

/**
 * Repository.
 */
class AuctionBidderRepository
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
   * @param array<mixed>
   *
   * @return array 
   */
  public function updateBid(array $data): array
  {
    $sql = "UPDATE auctions SET files_id = :files_id WHERE id = :id";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $data['auction_id']);
    $stmt->bindParam(':files_id', $data['files_id']);
    $status = $stmt->execute();

    if ($status) {
      $res['success'] = true;
    } else {
      $res['success'] = false;
    }

    return (array)$res;
  }
}
