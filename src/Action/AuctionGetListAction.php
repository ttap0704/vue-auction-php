<?php

namespace App\Action;

use App\Domain\Auction\Service\AuctionListGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AuctionGetListAction
{
    /**
     * @var AuctionListGetter
     */
    private $auctionListGetter;

    /**
     * The constructor.
     *
     * @param AuctionListGetter 
     */
    public function __construct(AuctionListGetter $auctionListGetter)
    {
        $this->auctionListGetter = $auctionListGetter;
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
        $data = $this->auctionListGetter->getList();

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($data));

        return $response->withStatus(201);
    }
}