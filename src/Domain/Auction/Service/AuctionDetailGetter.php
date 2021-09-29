<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionDetailGetterRepository;

/**
 * Service.
 */
final class AuctionDetailGetter
{
    /**
     * @var AuctionDetailGetterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionDetailGetterRepository $repository The repository
     */
    public function __construct(AuctionDetailGetterRepository $repository)
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
    public function getDetail($aid): array
    {
        $data = $this->repository->checkDetail($aid);

        return (array) $data;
    }
}