<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

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
    $resBody = array();

    if(!isset($args['user'], $args['pass']) {
      $resBody['error'] = "Please provide your username and password!";
      $response = $response->getBody()
                           ->write(json_encode($resBody)));

      return $response->withHeader('Location', '/');
    }

    $username = $request->get('user');
    $pass = $request->get('pass');

    $stmt = $this->pdo
                 ->query("SELECT id, password FROM users WHERE username = :username");
    $stmt->(['username' => $username]);

    $usr = $stmt->fetchAll();

    $stmt->close();

    if(COUNT($username) > 1) {
      $resBody['error'] = "More than one user exists with this username. Please contact the site administrator!";
      $response = $response->getBody()
                           ->write(json_encode($resBody['error']));
    } else if (COUNT($usr)) {

      if(password_verify($pass, $usr[0]['password'])) {

        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['uname'] = $username;
        $_SESSION['uid'] = $usr[0]['uid'];

        return $response->withHeader('Location', '/dashboard');
      } else {
        $resBody['error'] = "The username or password entered was invalid.";

        return $response->getBody()
                        ->write(json_encode($resBody))
                        ->withHeader('Location', '/');
      }
    } else {
      $resBody['error'] = "The username or password entered was invalid.";

      return $response->getBody()
                      ->write(json_encode($resBody))
                      ->withHeader('Location', '/');
    }
  }
}
