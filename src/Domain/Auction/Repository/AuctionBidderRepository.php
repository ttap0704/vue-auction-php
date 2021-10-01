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
    $res = [];
    $updated = $this->updateUserCash($data);
    if ($updated['success'] == true) {
      $insert_id = $this->insertBidDetails($data);
      if ($insert_id > 0) {
        $updated_auction = $this->updateAuction($data);
        if ($updated_auction > 0) {
          $res['success'] = true;
        } else {
          $res['success'] = false;
        }
      } else {
        $res['success'] = false;
      }
    } else {
      $res = $updated;
    }


    return (array)$res;
  }

  private function updateUserCash(array $data): array
  {
    $res = [];

    $id = $data['uid'];
    $use_cash = $data['cash'];

    $sql = "SELECT cash FROM users WHERE id = :id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $cash = $stmt->fetch()['cash'];

    $f_cash = (int)$cash - (int)$use_cash;
    if ($f_cash < 0) {
      $res['msg'] = '잔여 캐쉬가 부족합니다.';
      return $res;
    }

    $sql = "UPDATE users SET cash = :cash WHERE id = :id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':cash', $f_cash);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
      $res['success'] = true;
    } else {
      $res['success'] = false;
    }

    return $res;
  }

  private function insertBidDetails(array $data): int
  {
    $res = 0;

    $bidder = (int)$data['uid'];
    $auction_id = (int)$data['aid'];
    $price = (int)$data['cash'];

    $sql = "INSERT INTO bid_details SET
    bidder=:bidder,
    auction_id=:auction_id,
    price=:price";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':bidder', $bidder);
    $stmt->bindParam(':auction_id', $auction_id);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
    $res = $this->connection->lastInsertId();

    return $res;
  }

  private function updateAuction(array $data): int
  {
    $f_bidder = $data['uid'];
    $c_price = $data['cash'];
    $aid = $data['aid'];

    $sql = "UPDATE auctions SET f_bidder = :f_bidder, c_price = :c_price WHERE id = :aid";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':f_bidder', $f_bidder);
    $stmt->bindParam(':c_price', $c_price);
    $stmt->bindParam(':aid', $aid);
    $stmt->execute();
    $res = $stmt->rowCount();

    return $res;
  }
}
