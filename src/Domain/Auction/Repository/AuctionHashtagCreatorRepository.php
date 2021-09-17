<?php

namespace App\Domain\Auction\Repository;

use PDO;
use Odan\Session\SessionInterface;

/**
 * Repository.
 */
class AuctionHashtagCreatorRepository
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
  public function __construct(PDO $connection, SessionInterface $session)
  {
    $this->connection = $connection;
    $this->session = $session;
  }

  /**
   * @param array<mixed>
   *
   * @return array 
   */
  public function returnHashtag(array $data): array
  {
    $f_res = [];

    for ($i = 0, $leng = count($data['hashtag']); $i < $leng; $i++) {
      $row = [
        'hashtag' => $data['hashtag'][$i],
      ];

      $find_id = $this->findAuctionHashtag($row['hashtag']);
      
      if ($find_id == 0) {
        $res = $this->insertAuctionHashtag($row['hashtag']);
      } else {
        $res = $find_id;
      }

      array_push($f_res, $res);
    }

    return (array) $f_res;
  }

  private function insertAuctionHashtag(string $hashtag): int
  {

    $sql = "INSERT INTO auctions SET 
            hashtag=:hashtag";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':hashtag', $hashtag);
    $stmt->execute();

    $res = (int)$this->connection->lastInsertId();

    return (int) $res;
  }

  private function findAuctionHashtag(string $hashtag): int
  {
    $new_res = 0;

    $sql = "SELECT id FROM hashtags WHERE hashtag = :hashtag";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':hashtag', $hashtag);
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res > 0) {
      $new_res = $res;
    } else {
      $new_res = 0;
    }

    return (int) $new_res;
  }
}
