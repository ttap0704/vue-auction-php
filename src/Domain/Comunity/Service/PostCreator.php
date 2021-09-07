<?php

namespace App\Domain\Comunity\Service;

use App\Domain\Comunity\Repository\PostCreatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class PostCreator
{
    /**
     * @var PostCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param PostCreatorRepository $repository The repository
     */
    public function __construct(PostCreatorRepository $repository)
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
    public function createUser(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertUser($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

    /**
     * Input validation.
     *
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['title'])) {
            $errors['title'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}