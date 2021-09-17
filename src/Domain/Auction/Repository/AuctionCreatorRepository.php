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
            'host' => $this->session->get('uid'),
            'title' => $post['title'],
            'content' => $post['content'],
            's_price' => $post['s_price'],
            'e_price' => $post['e_price'],
        ];

        $sql = "INSERT INTO auctions SET 
                host_id=:host, 
                title=:title,
                content=:content,
                s_price=:s_price,
                e_price=:e_price";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':host', $row['host']);
        $stmt->bindParam(':title', $row['title']);
        $stmt->bindParam(':content', $row['content']);
        $stmt->bindParam(':s_price', $row['s_price']);
        $stmt->bindParam(':e_price', $row['e_price']);
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }
}
