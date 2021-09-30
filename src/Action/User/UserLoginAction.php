<?php

namespace App\Action\User;

use Odan\Session\SessionInterface;
use App\Domain\User\Service\UserLogin;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class UserLoginAction
{
  /**
   * @var UserLogin
   */
  private $userLogin;

  /**
   * The constructor.
   *
   * @param UserLogin $UserLogin The user creator
   */
  public function __construct(UserLogin $userLogin, SessionInterface $session)
  {
    $this->userLogin = $userLogin;
    $this->session = $session;
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
    // Clear all flash messages
    $flash = $this->session->getFlash();
    $flash->clear();

    $data = (array)$request->getParsedBody();

    $userData = $this->userLogin->loginUser($data);

    $result = [
      'user_data' => $userData
    ];

    $flash = $this->session->getFlash();
    $flash->clear();

    if ($result['user_data']['pass'] == true) {
      $this->session->destroy();
      $this->session->start();
      $this->session->regenerateId();

      $this->session->set('uid', $result['user_data']['id']);
      $this->session->set('email', $result['user_data']['email']);
      $flash->add('success', 'Login successfully');
    }

    $response->getBody()->write((string)json_encode($result));
    // Build the HTTP response

    return $response->withStatus(201);
  }
}
