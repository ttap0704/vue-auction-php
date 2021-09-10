<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserCashChargerRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserCashCharger
{
    /**
     * @var UserCashChargerRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserCashChargerRepository $repository The repository
     */
    public function __construct(UserCashChargerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array<mixed> $data The form data
     * 
     *
     * @return int The new user ID
     */
    public function chargeCash(array $data): array
    {
        $this->validateUserCash($data);

        $res = $this->repository->updateCash($data);

        return (array) $res;
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
    private function validateUserCash(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['id'])) {
            $errors['id'] = 'Input required';
        } 

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}