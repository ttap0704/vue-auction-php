<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionBidderRepository;

/**
 * Service.
 */
final class AuctionCreator
{
    /**
     * @var AuctionBidderRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionBidderRepository $repository The repository
     */
    public function __construct(AuctionBidderRepository $repository)
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
    public function bidAuction(array $data): int
    {
        $auction_id = $this->repository->updateBid($data);

        return $auction_id;
    }
}