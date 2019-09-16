
<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controller\Authenticate;

// $app->get('/', function (Request $request, Response $response, array $args) {
//   return $this->get('renderer')->render($response, "index.phtml", $args);
// });

$app->get('/', HomeController::class . ':view');

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
  return $this->get('renderer')->render($response, "hello.phtml", $args);
});

$app->get('/timestamp', function (Request $request, Response $response) {
  $timestamp = date('H:i:s');
  return $request-getBody()->write($timestamp);
});

$app->post('/authenticate', AuthenticationController::class . ':authenticate');

$app->get('/dashboard', DashboardController::class . ':view')->add($authenticationMiddleware);

$app->get('/account', UserAccountController::class . ':view')->add($authenticationMiddleware);
