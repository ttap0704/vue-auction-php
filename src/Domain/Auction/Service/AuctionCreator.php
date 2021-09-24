<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionCreatorRepository;

/**
 * Service.
 */
final class AuctionCreator
{
    /**
     * @var AuctionCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionCreatorRepository $repository The repository
     */
    public function __construct(AuctionCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new user ID
     */
    public function createAuction(array $data): int
    {
        $auction_id = $this->repository->insertAuction($data);

        return $auction_id;
    }
}