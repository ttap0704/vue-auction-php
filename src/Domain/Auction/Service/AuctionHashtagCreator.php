<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionHashtagCreatorRepository;

/**
 * Service.
 */
final class AuctionHashtagCreator
{
    /**
     * @var AuctionHashtagCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionHashtagCreatorRepository $repository The repository
     */
    public function __construct(AuctionHashtagCreatorRepository $repository)
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
    public function createHashtag(array $data): array
    {
        $hashtags = $this->repository->returnHashtag($data);
        // $hashtags = $data;

        return (array) $hashtags;
    }
}