<?php
declare(strict_types=1);
ini_set("display_errors", 1);
define("APP_ROOT",dirname(__DIR__));

require APP_ROOT . "/vendor/autoload.php";

use Dotenv\Dotenv;
use HttpSoft\Emitter\SapiEmitter;
use GuzzleHttp\Psr7\ServerRequest;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;


$dotenv=Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

// Start the session once at the top of every request so views and
// middleware can read $_SESSION without each calling session_start().
session_start();

$request = ServerRequest::fromGlobals();
$router = new Router;

$builder = new DI\ContainerBuilder;

$builder->addDefinitions(APP_ROOT . "/config/definitions.php");
$builder->useAttributes(true);
$container = $builder->build();

$strategy = new ApplicationStrategy;
$strategy->setContainer($container);
$router->setStrategy($strategy);

// Pass the container to routes so middleware can be resolved with DI.
$routes = require APP_ROOT . "/config/routes.php";
$routes($router, $container);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;
$emitter->emit($response);