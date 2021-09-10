<?php

namespace App\Action;

use App\Domain\User\Service\UserCashCharger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class UserCashChargeAction
{
    /**
     * @var UserCashCharger
     */
    private $userCashCharger;

    /**
     * The constructor.
     *
     * @param UserCashCharger $userCreator The user creator
     */
    public function __construct(UserCashCharger $userCashCharger)
    {
        $this->userCashCharger = $userCashCharger;
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = (array)$request->getParsedBody();

        $res = $this->userCashCharger->chargeCash($data);

        $response->getBody()->write((string)json_encode($res));

        return $response->withStatus(201);
    }
}