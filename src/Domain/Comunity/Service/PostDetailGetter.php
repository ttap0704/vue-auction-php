<?php

namespace App\Domain\Comunity\Service;

use App\Domain\Comunity\Repository\PostDetailGetterRepository;

/**
 * Service.
 */
final class PostDetailGetter
{
    /**
     * @var PostDetailGetterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param PostDetailGetterRepository $repository The repository
     */
    public function __construct(PostDetailGetterRepository $repository)
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
    public function getDetail($pid): array
    {
        $detail = $this->repository->checkDetail($pid);
        return $detail;
    }
}