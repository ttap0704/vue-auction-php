<?php

namespace App\Action\Post;

use App\Domain\Comunity\Service\PostDetailGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class PostDetailGetAction
{
    /**
     * @var PostDetailGetter
     */
    private $postDetailGetter;

    /**
     * The constructor.
     *
     * @param PostDetailGetter 
     */
    public function __construct(PostDetailGetter $postDetailGetter)
    {
        $this->postDetailGetter = $postDetailGetter;
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
        // Invoke the Domain with inputs and retain the result
        $detail = $this->postDetailGetter->getDetail($args["pid"]);

        // Transform the result into the JSON representation
        $result = [
            'detail' => $detail
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(201);
    }
}