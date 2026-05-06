<?php
declare(strict_types=1);
ini_set("display_errors", 1);

// Chemin racine du projet
define("APP_ROOT", dirname(__DIR__));

// Charge toutes les librairies installées via Composer
require APP_ROOT . "/vendor/autoload.php";

use Dotenv\Dotenv;
use HttpSoft\Emitter\SapiEmitter;
use GuzzleHttp\Psr7\ServerRequest;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

// Charge les variables d'environnement depuis le fichier .env
$dotenv = Dotenv::createImmutable(APP_ROOT);//méthode de la librairie vlucas/phpdotenv (crée un chargeur de .env en lecture seule.)
$dotenv->load();

// Démarre la session une seule fois pour toute la requête
session_start();

// Transforme $_GET, $_POST, $_SERVER en un objet propre
$request = ServerRequest::fromGlobals();
$router = new Router;

// Construit le conteneur d'injection de dépendances
$builder = new DI\ContainerBuilder;
$builder->addDefinitions(APP_ROOT . "/config/definitions.php");
$builder->useAttributes(true);
$container = $builder->build();

// Donne le conteneur au router pour construire les controllers automatiquement
$strategy = new ApplicationStrategy;
$strategy->setContainer($container);
$router->setStrategy($strategy);

// Charge la liste des routes
$routes = require APP_ROOT . "/config/routes.php";
$routes($router, $container);

// Le router analyse l'URL, exécute le bon controller, retourne une réponse
$response = $router->dispatch($request);

// Envoie la réponse HTTP au navigateur
$emitter = new SapiEmitter;
$emitter->emit($response);