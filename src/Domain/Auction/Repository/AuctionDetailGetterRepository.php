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
  public function checkDetail($aid): array
  {
    $row = [];
    $sql = "SELECT *, auctions.id AS id, auctions.created_at AS created_at
    FROM auctions 
    LEFT JOIN users ON auctions.host_id = users.id 
    WHERE auctions.id = :id
    ORDER BY auctions.created_at DESC LIMIT 20";


    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':id', $aid);
    $stmt->execute();
    $res = $stmt->fetch();

    $row = [];

    $row["id"] = $res["id"];
    $row["content"] = $res["content"];
    $row["title"] = $res["title"];
    $row["created_at"] = $res["created_at"];
    $row["uid"] = $res["host_id"];
    $row["unick"] = $res["nick"];
    $row["done"] = $res["done"];
    $row["s_price"] = $res["s_price"];
    $row["c_price"] = $res["c_price"];
    $row["d_price"] = $res["d_price"];
    $row["hashtags"] = $this->getHashtags($res["hashtags"]);
    $row["images"] = $this->getImages($res["id"]);
    $row["history"] = $this->getHistory($res["id"]);

    return (array) $row;
  }

  private function getHashtags(string $hashtags): array
  {
    $row = [];

    if (strlen($hashtags) > 0) {
      $where_query = "(" . $hashtags . ")";

      $sql = "SELECT hashtag FROM hashtags WHERE id IN $where_query";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll();

      for ($i = 0, $leng = count($res); $i < $leng; $i++) {
        array_push($row, $res[$i]['hashtag']);
      }
    }

    return (array) $row;
  }

  private function getImages(string $auction_id): array
  {
    $row = [];

    $sql = "SELECT file_name FROM files WHERE auction_id = :auction_id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':auction_id', $auction_id);
    $stmt->execute();
    $res = $stmt->fetchAll();

    if (count($res) > 0) {
      for ($i = 0, $leng = count($res); $i < $leng; $i++) {
        array_push($row, $res[$i]['file_name']);
      }
    } else {
      array_push($row, null);
    }

    return (array) $row;
  }

  private function getHistory(string $auction_id): array
  {
    $row = [];

    $sql = "SELECT bid_at, price, bid_details.id AS id, users.nick AS unick FROM bid_details 
    LEFT JOIN users ON bid_details.bidder = users.id 
    WHERE auction_id = :auction_id
    ORDER BY bid_details.bid_at DESC";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':auction_id', $auction_id);
    $stmt->execute();
    $res = $stmt->fetchAll();

    if (count($res) > 0) {
      for ($i = 0, $leng = count($res); $i < $leng; $i++) {
        array_push($row, $res[$i]);
      }
    } else {
      array_push($row, null);
    }

    return (array) $row;
  }
}
