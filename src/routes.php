<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, "hello.phtml", $args);
});

$app->get('/timestamp', function (Request $request, Response $response) {
  $timestamp = date('H:i:s');
  return $request-getBody()->write($timestamp);
});
