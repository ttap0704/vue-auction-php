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
    public function getList($params): array
    {
        $data = array();

        $hashtag = "";
        if (isset($params['hashtag'])) {
            $hashtag = $params['hashtag'];
        }
        $data = $this->repository->checkList($hashtag);
        // $data['test'] = $hashtag;

        return (array) $data;
    }
}
