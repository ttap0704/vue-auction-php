<?php

namespace App\Action\Auction;

use App\Domain\Auction\Service\AuctionImageUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Action
 */
final class AuctionImageUpdateAction
{
  /**
   * @var AuctionImageUpdater
   */
  private $auctionImageUpdater;

  /**
   * The constructor.
   *
   * @param AuctionImageUpdater 
   */
  public function __construct(AuctionImageUpdater $auctionImageUpdater)
  {
    $this->auctionImageUpdater = $auctionImageUpdater;
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

    $res = $this->auctionImageUpdater->updateAuctionImages($data);

    // Build the HTTP response

    $response->getBody()->write((string)json_encode($res));

    return $response->withStatus(201);
  }
}
