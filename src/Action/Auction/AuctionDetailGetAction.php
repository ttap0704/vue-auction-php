<?php

namespace App\Action\Auction;

use App\Domain\Auction\Service\AuctionDetailGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AuctionDetailGetAction
{
    /**
     * @var AuctionDetailGetter
     */
    private $auctionDetailGetter;

    /**
     * The constructor.
     *
     * @param AuctionDetailGetter 
     */
    public function __construct(AuctionDetailGetter $auctionDetailGetter)
    {
        $this->auctionDetailGetter = $auctionDetailGetter;
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $aid = $args['aid'];
        $data = $this->auctionDetailGetter->getDetail($aid);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($data));

        return $response->withStatus(201);
    }
}
