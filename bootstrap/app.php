
<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/kernel.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

require_once(__DIR__ . '/../src/dependencies.php');
require_once(__DIR__ . '/../src/middleware.php');
require_once(__DIR__ . '/../src/routes.php');
