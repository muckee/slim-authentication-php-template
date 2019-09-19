<?php

// Initialise container
///////////////////////
$container = $app->getContainer();

// Logger
/////////
$container->set('logger', function ($c) {
  $logger = new Monolog\Logger('slim-php-template');
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());

  if (!empty(__DIR__ . '/../var/log/slim-php-template.error.log')) {
    $logger->pushHandler(new Monolog\Handler\StreamHandler(__DIR__ . '/../var/log/slim-php-template.error.log', Monolog\Logger::DEBUG));
  } else {
    $logger->pushHandler(new Monolog\Handler\ErrorLogHandler(0, Monolog\Logger::DEBUG, true, true));
  }

  return $logger;
});

// View renderer
////////////////
$container->set('renderer', function ($c) {
  return new Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

// PDO MySQL connection
///////////////////////
$container->set('mysql', function ($c) {
  $host = getenv("MYSQL_HOST");
  $db = getenv("MYSQL_DB");
  $charset = getenv("MYSQL_CHARSET");
  $user = getenv("MYSQL_USER");
  $pass = getenv("MYSQL_PASS");

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
  ];

  try{
    $dbh = new pdo( $dsn,
                    $user,
                    $pass,
                    $options );
    return $dbh;
  }
  catch(PDOException $e){
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
});

// Controller containers
////////////////////////

$container->set('HomeController', function ($c) {
  $renderer = $c->get('renderer');
  return new App\Controller\HomeController($renderer);
});

$container->set('AuthenticationController', function ($c) {
  $pdo = $c->get('mysql');
  return new App\Controller\AuthenticationController($pdo);
});

$container->set('RegistrationController', function ($c) {
  $pdo = $c->get('mysql');
  $renderer = $c->get('renderer');
  return new App\Controller\RegistrationController($pdo, $renderer);
});

$container->set('DashboardController', function ($c) {
  $renderer = $c->get('renderer');
  return new App\Controller\DashboardController($renderer);
});

$container->set('UserAccountController', function ($c) {
  return new App\Controller\UserAccountController();
});
