<?php

namespace App\Action;

use App\Domain\Auction\Service\AuctionHashtagCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AuctionHashtagCreateAction
{
    /**
     * @var AuctionHashtagCreator
     */
    private $auctionHashtagCreator;

    /**
     * The constructor.
     *
     * @param AuctionHashtagCreator 
     */
    public function __construct(AuctionHashtagCreator $auctionHashtagCreator)
    {
        $this->auctionHashtagCreator = $auctionHashtagCreator;
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

        // Invoke the Domain with inputs and retain the result
        $hashtags = $this->auctionHashtagCreator->createHashtag($data);

        // Transform the result into the JSON representation
        $result = [
            'hashtags' => $hashtags
        ];

        // // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(201);
    }
}