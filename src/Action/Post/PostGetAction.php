<?php

namespace App\Action\Post;

use App\Domain\Comunity\Service\PostGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class PostGetAction
{
    /**
     * @var PostGetter
     */
    private $postGetter;

    /**
     * The constructor.
     *
     * @param PostGetter 
     */
    public function __construct(PostGetter $postGetter)
    {
        $this->postGetter = $postGetter;
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
        // Invoke the Domain with inputs and retain the result
        $posts = $this->postGetter->getPosts();

        // Transform the result into the JSON representation
        $result = [
            'posts' => $posts,
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(200);
    }
}