<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\Stream;

/**
 * Authentication controller
 *
 * Authenticates user login requests.
 *
 * @copyright  2019 Joshua Flood
 * @license    https://github.com/JoshuaFlood/slim-authentication-php-template/blob/master/LICENSE   MIT License
 * @link       https://github.com/JoshuaFlood/slim-authentication-php-template
 */
class AuthenticationController
{

  protected $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  /**
   * Authenticates user login attempts
   *
   * @param Slim\Psr7\Request   $request PSR-7 compliant request object
   * @param Slim\Psr7\Response $response PSR-7 compliant response object
   *
   * @throws Slim\Psr7\Response If something interesting cannot happen
   * @author Joshua Flood <info@joshuaflood.com>
   * @return Slim\Psr7\Response
   */
  public function authenticate(Request $request, Response $response, array $args)
  {
    $errors = array(
      'error' => ""
    );

    $reqBody = $request->getParsedBody();

    $username = $reqBody['user'];
    $pass = $reqBody['pass'];

    if(!strlen($username) || !strlen($pass)) {
      $errors['error'] = "Please provide your username and password!";
      $payload = json_encode($errors);
      $body = $response->getBody();
      $body->write($payload);
      $response->withBody($body);
      return $response->withHeader('Location', '/');
    }
    $stmt = $this->pdo
                 ->prepare("SELECT id,password FROM oauth_users WHERE username=:username");
    $params = array(
      'username' => $username
    );
    $stmt->execute($params);
    if($usr = $stmt->fetch()) {
      if(password_verify($pass, $usr['password'])) {
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['uname'] = $username;
        $_SESSION['uid'] = $usr['id'];
        return $response->withHeader('Location', '/dashboard');
      } else {
        $error['error'] = "The username or password entered was invalid.";
        return $response->getBody()
                        ->write(json_encode($error))
                        ->withHeader('Location', '/');
      }
    }
    $error['error'] = "The username or password entered was invalid.";

    return $response->getBody()
                    ->write(json_encode($error))
                    ->withHeader('Location', '/');
  }
}
