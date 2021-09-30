<?php

namespace App\Domain\Auction\Repository;

use PDO;
use Odan\Session\SessionInterface;

/**
 * Repository.
 */
class AuctionCreatorRepository
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
     * @return int 
     */
    public function insertAuction(array $post): int
    {
        $row = [
            'host' => $post['host'],
            'title' => $post['title'],
            'content' => $post['content'],
            's_price' => $post['s_price'],
            'c_price' => $post['s_price'],
            'd_price' => $post['d_price'],
            'hashtags' => $post['hashtags']
        ];

        $sql = "INSERT INTO auctions SET 
                host_id=:host, 
                title=:title,
                content=:content,
                s_price=:s_price,
                c_price=:c_price,
                d_price=:d_price,
                hashtags=:hashtags";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':host', $row['host']);
        $stmt->bindParam(':title', $row['title']);
        $stmt->bindParam(':content', $row['content']);
        $stmt->bindParam(':s_price', $row['s_price']);
        $stmt->bindParam(':c_price', $row['c_price']);
        $stmt->bindParam(':d_price', $row['d_price']);
        $stmt->bindParam(':hashtags', $row['hashtags']);
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }
}
