<?php

$container = $app->getContainer();

// view renderer
$container->set('renderer', function ($c) {
    return new Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$container->set('logger', function ($c) {
    $logger = new Monolog\Logger('slim-php-template');
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    if (!empty(__DIR__ . '/../var/log/slim-php-template.error.log')) {
        $logger->pushHandler(new Monolog\Handler\StreamHandler(__DIR__ . '/../var/log/slim-php-template.error.log', Monolog\Logger::DEBUG));
    } else {
        $logger->pushHandler(new Monolog\Handler\ErrorLogHandler(0, Monolog\Logger::DEBUG, true, true));
    }
    return $logger;
};
