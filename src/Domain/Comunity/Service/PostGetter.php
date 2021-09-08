<?php

namespace App\Domain\Comunity\Service;

use App\Domain\Comunity\Repository\PostGetterRepository;

/**
 * Service.
 */
final class PostGetter
{
    /**
     * @var PostGetterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param PostGetterRepository $repository The repository
     */
    public function __construct(PostGetterRepository $repository)
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
    public function getPosts(): array
    {

        // Insert user
        $posts = $this->repository->checkPosts();

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $posts;
    }
}