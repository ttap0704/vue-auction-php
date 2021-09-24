<?php

namespace App\Domain\Auction\Repository;

use PDO;

/**
 * Repository.
 */
class AuctionImageAdderRepository
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
  public function addImages(array $data): array
  {
    $f_res = [];
    $res = 0;

    for ($i = 0, $leng = count($data); $i < $leng; $i++) {
      $row = [
        'file_name' => $data[$i]['file_name'],
        'user_id' => $data[$i]['user_id'],
        'auction_id' => $data[$i]['auction_id'],
      ];

      $find_id = $this->checkImage((array) $row);
      if ($find_id == 0) {
        $res = $this->insertImage((array) $row);
      } else {
        $res = $find_id;
      }

      array_push($f_res, $res);
    }

    return (array) $f_res;
  }

  private function insertImage(array $data): int
  {
    $sql = "INSERT INTO files SET 
                file_name=:file_name, 
                user_id=:user_id,
                auction_id=:auction_id";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':file_name', $data['file_name']);
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->bindParam(':auction_id', $data['auction_id']);
    $stmt->execute();

    return (int)$this->connection->lastInsertId();
  }

  private function checkImage(array $data): int
  {
    $new_res = 0;

    $sql = "SELECT id FROM files 
    WHERE file_name = :file_name 
    AND user_id = :user_id 
    AND auction_id = :auction_id";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':file_name', $data['file_name']);
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->bindParam(':auction_id', $data['auction_id']);
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res['id'] > 0) {
      $new_res = $res['id'];
    } else {
      $new_res = 0;
    }

    return (int) $new_res;
  }
}
