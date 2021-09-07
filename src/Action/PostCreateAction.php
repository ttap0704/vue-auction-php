<?php

namespace App\Action;

use App\Domain\Comunity\Service\PostCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class PostCreateAction
{
    /**
     * @var PostCreator
     */
    private $postCreator;

    /**
     * The constructor.
     *
     * @param PostCreator $userCreator The user creator
     */
    public function __construct(PostCreator $postCreator)
    {
        $this->postCreator = $postCreator;
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
        $post_id = $this->postCreator->createUser($data);

        // Transform the result into the JSON representation
        $result = [
            'post_id' => $post_id
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(201);

        
    }
}