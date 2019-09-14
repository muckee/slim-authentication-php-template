<?php

use PDO;

$container = $app->getContainer();

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

// view renderer
$container->set('renderer', function ($c) {
  return new Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$container->set('mysql', function ($c) {
  $host = getenv("MYSQL_HOST");
  $db = getenv("MYSQL_DB");
  $charset = getenv("MYSQL_CHARSET");

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
  ];

  $user = getenv("MYSQL_USER");
  $pass = getenv("MYSQL_PASS");

  try {
    $pdo = new PDO($dsn, $user, $pass, $options);

  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());

  }
});
