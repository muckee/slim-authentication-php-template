<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * User dashboard controller
 *
 * Returns user dashboard page route and handles requests from the dashboard page.
 *
 * @copyright  2019 Joshua Flood
 * @license    https://github.com/JoshuaFlood/slim-authentication-php-template/blob/master/LICENSE   MIT License
 * @link       https://github.com/JoshuaFlood/slim-authentication-php-template
 */
class DashboardController
{
  protected $renderer;

  public function __construct($renderer)
  {
    $this->renderer = $renderer;
  }

  /**
   * Creates user dashboard page view
   *
   * @param Slim\Psr7\Request  $request  PSR-7 compliant request object
   * @param Slim\Psr7\Response $response PSR-7 compliant response object
   *
   * @throws Slim\Psr7\Response If something interesting cannot happen
   * @author Joshua Flood <info@joshuaflood.com>
   * @return Slim\Psr7\Response
   */
  public function view(Request $request, Response $response, array $args)
  {
    session_start();

    if(!isset($_SESSION['loggedin'])) {
      return $response->withHeader('Location', '/');
    }

    return $this->renderer->render($response, "dashboard.phtml", $args);
  }
}
