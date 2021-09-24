<?php

namespace App\Action;

use App\Domain\Auction\Service\AuctionImageAdder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Action
 */
final class AuctionImageAddAction
{
  /**
   * @var AuctionImageAdder
   */
  private $auctionImageAdder;

  /**
   * The constructor.
   *
   * @param AuctionImageAdder 
   */
  public function __construct(AuctionImageAdder $auctionImageAdder)
  {
    $this->auctionImageAdder = $auctionImageAdder;
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

    $res = $this->auctionImageAdder->createAuctionImages($data);

    // Build the HTTP response

    $response->getBody()->write((string)json_encode($res));

    return $response->withStatus(201);
  }
}
