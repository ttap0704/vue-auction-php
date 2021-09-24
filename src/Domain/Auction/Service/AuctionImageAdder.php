<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionImageAdderRepository;

/**
 * Service.
 */
final class AuctionImageAdder
{
    /**
     * @var AuctionImageAdderRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionImageAdderRepository $repository The repository
     */
    public function __construct(AuctionImageAdderRepository $repository)
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

    public function createAuctionImages(array $data): array
    {
        $res = $this->repository->addImages($data);

        return (array) $res;
    }
}