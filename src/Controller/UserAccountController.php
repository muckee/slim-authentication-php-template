
<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * User account management controller
 *
 * Returns user account page route and handles requests from the user's account page.
 *
 * @copyright  2019 Joshua Flood
 * @license    https://github.com/JoshuaFlood/slim-authentication-php-template/blob/master/LICENSE   MIT License
 * @link       https://github.com/JoshuaFlood/slim-authentication-php-template
 */
class UserAccountController
{
  protected $pdo;
  protected $renderer;

  public function __construct ($pdo, $renderer)
  {
    $this->pdo = $pdo;
    $this->renderer = $renderer;
  }

  /**
   * Creates user account page view
   *
   * @param Slim\Psr7\Request   $request PSR-7 compliant request object
   * @param Slim\Psr7\Response $response PSR-7 compliant response object
   *
   * @throws Slim\Psr7\Response If something interesting cannot happen
   * @author Joshua Flood <info@joshuaflood.com>
   * @return Slim\Psr7\Response
   */
  public function view(Request $request, Response $response, array $args)
  {
    if(!isset($_SESSION['loggedin'])) {
      return $response->withHeader('Location', '/');
    }
    $stmt = $this->pdo->prepare("SELECT username, email FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['id']]);
    $user = $stmt->fetch();
    $args['username'] = $user['username'];
    $args['email'] = $user['email'];
    return $this->renderer->render($response, "account.phtml", $args);
  }
}
