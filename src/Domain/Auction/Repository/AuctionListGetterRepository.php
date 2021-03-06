<?php

namespace App\Domain\Auction\Repository;

use PDO;

use function DI\string;

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
  public function checkList($hashtag): array
  {
    $row = [];
    $where = "";
    if (strlen($hashtag) > 0) {
      $hashtag_ids = explode(",", $this->getHashtagId($hashtag));
      $where = "AND (";
      for ($i = 0, $leng = count($hashtag_ids); $i < $leng; $i++) {
        $h_id = $hashtag_ids[$i];
        $where .= "hashtags LIKE '%$h_id%'";

        if ($i != $leng - 1) {
          $where .= " OR ";
        }
      }
      $where .= ")";
    }

    $sql = "SELECT *, auctions.id AS id, auctions.created_at AS created_at
    FROM auctions 
    LEFT JOIN users ON auctions.host_id = users.id 
    WHERE auctions.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND auctions.done = 0 $where
    ORDER BY auctions.created_at DESC LIMIT 20";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll();

    if ($res) {
      for ($i = 0, $leng = count($res); $i < $leng; $i++) {
        $row[$i]["id"] = $res[$i]["id"];
        $row[$i]["content"] = $res[$i]["content"];
        $row[$i]["title"] = $res[$i]["title"];
        $row[$i]["created_at"] = $res[$i]["created_at"];
        $row[$i]["uid"] = $res[$i]["host_id"];
        $row[$i]["unick"] = $res[$i]["nick"];
        $row[$i]["done"] = $res[$i]["done"];
        $row[$i]["s_price"] = $res[$i]["s_price"];
        $row[$i]["c_price"] = $res[$i]["c_price"];
        $row[$i]["d_price"] = $res[$i]["d_price"];
        $row[$i]["hashtags"] = $this->getHashtags($res[$i]["hashtags"]);
        $row[$i]["images"] = $this->getImages($res[$i]["id"]);
      }
    }

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
      if (count($res) > 0) {
        for ($i = 0, $leng = count($res); $i < $leng; $i++) {
          array_push($row, $res[$i]['hashtag']);
        }
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

  private function getHashtagId(string $hashtag)
  {
    $sql = "SELECT GROUP_CONCAT(id) AS ids FROM hashtags WHERE hashtag LIKE '%$hashtag%'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch()['ids'];

    return $res;
  }
}
