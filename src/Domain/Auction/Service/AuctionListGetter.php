<?php

namespace App\Domain\Auction\Service;

use App\Domain\Auction\Repository\AuctionListGetterRepository;

/**
 * Service.
 */
final class AuctionListGetter
{
    /**
     * @var AuctionListGetterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AuctionListGetterRepository $repository The repository
     */
    public function __construct(AuctionListGetterRepository $repository)
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
    public function getList(): array
    {
        $data = $this->repository->checkList();

        return (array) $data;
    }
}