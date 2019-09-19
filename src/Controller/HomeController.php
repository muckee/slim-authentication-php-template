<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController
{
  protected $renderer;

  public function __construct ($renderer)
  {
    $this->renderer = $renderer;
  }

  public function view (Request $request, Response $response, array $args)
  {
    $args['pageTitle'] = "index";
    if(!isset($_SESSION['loggedin'])) {
      $reqBody = $request->getParsedBody();
      if(isset($reqBody['error'])) {
        $args['error'] = $reqBody['error'];
      }
      return $this->renderer->render($response, "index.phtml", $args);
    }
    return $response->withHeader('Location', '/dashboard');
  }
}
