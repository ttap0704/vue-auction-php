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

    $last_bidder_updated = $this->lastBidderUpdate($data);

    if ($last_bidder_updated['success']) {
      $updated = $this->updateUserCash($data);
      if ($updated['success'] == true) {
        $insert_id = $this->insertBidDetails($data);
        if ($insert_id > 0) {
          $updated_auction = $this->updateAuction($data);
          if ($updated_auction > 0) {
            $res['success'] = true;
            $res['remain_cash'] = $this->getUserCash($data);
          } else {
            $res['success'] = false;
          }
        } else {
          $res['success'] = false;
        }
      } else {
        $res['success'] = false;
      }
    } else {
      $res['success'] = false;
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

  private function lastBidderUpdate(array $data)
  {
    $row = [];

    $aid = $data['aid'];

    $sql = "SELECT price, bidder FROM bid_details WHERE auction_id = :aid ORDER BY id DESC LIMIT 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':aid', $aid);
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res != false) {
      $sql = "UPDATE users SET cash = (cash + :price) WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':id', $res['bidder']);
      $stmt->bindParam(':price', $res['price']);
      $stmt->execute();
      $count = $stmt->rowCount();

      if ($count > 0) {
        $row = array(
          'success' => true,
          'price' => $res['price'],
          'uid' => $res['bidder']
        );
      } else {
        $row = array(
          'success' => false
        );
      }
    } else {
      $row = array(
        'success' => true,
      );
    }

    return $row;
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

    $sql = "SELECT d_price FROM auctions WHERE id = :aid";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':aid', $aid);
    $stmt->execute();
    $res = $stmt->fetch();

    $done = "";
    if ($res['d_price'] <= $c_price) {
      $done = "done = 1";
    }

    $sql = "UPDATE auctions SET f_bidder = :f_bidder, c_price = :c_price, $done WHERE id = :aid";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':f_bidder', $f_bidder);
    $stmt->bindParam(':c_price', $c_price);
    $stmt->bindParam(':aid', $aid);
    $stmt->execute();
    $res = $stmt->rowCount();

    return $res;
  }

  private function getUserCash(array $data): array
  {
    $id = $data['uid'];

    $sql = "SELECT cash FROM users WHERE id = :id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res['cash'] = $stmt->fetch()['cash'];

    return $res;
  }
}
