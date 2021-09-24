<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionImageUpdaterRepository;

/**
 * Service.
 */
final class AuctionImageUpdater
{
    /**
     * @var AuctionImageUpdaterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionImageUpdaterRepository $repository The repository
     */
    public function __construct(AuctionImageUpdaterRepository $repository)
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

    public function updateAuctionImages(array $data): array
    {
        $res = $this->repository->updateImage($data);

        return (array) $res;
    }
}