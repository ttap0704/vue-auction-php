<?php

namespace App\Action\Auction;

use App\Domain\Auction\Service\AuctionBidder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AuctionBidAction
{
  /**
   * @var AuctionBidder
   */
  private $auctionBidder;

  /**
   * The constructor.
   *
   * @param AuctionBidder 
   */
  public function __construct(AuctionBidder $auctionBidder)
  {
    $this->auctionBidder = $auctionBidder;
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

    $res = $this->auctionBidder->bidAuction($data);

    // Build the HTTP response
    $response->getBody()->write((string)json_encode(['result' => $res]));

    return $response->withStatus(201);
  }
}
