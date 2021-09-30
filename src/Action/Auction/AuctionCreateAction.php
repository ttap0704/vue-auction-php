<?php

namespace App\Action\Auction;

use App\Domain\Auction\Service\AuctionCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AuctionCreateAction
{
    /**
     * @var AuctionCreator
     */
    private $auctionCreator;

    /**
     * The constructor.
     *
     * @param AuctionCreator 
     */
    public function __construct(AuctionCreator $auctionCreator)
    {
        $this->auctionCreator = $auctionCreator;
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
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $auction_id = $this->auctionCreator->createAuction($data);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode(['result' => $auction_id]));

        return $response->withStatus(201);
    }
}