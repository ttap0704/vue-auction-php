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

    for ($i = 0, $leng = count($data); $i < $leng; $i++) {
      $row = [
        'hashtag' => $data[$i],
      ];

      array_push($row);
    }

    return (array) $f_res;
  }
}
