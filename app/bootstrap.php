<?php

/**
 * This bootstrap file is the real starting point for the application.
 *
 * It is required from the public index.php, and is used as the backbone of the application.
 * Every request starts and ends in this file.
 */

define("PROJECT_ROOT", realpath(getcwd() . "/../"));

# Include FastRouter #

require_once PROJECT_ROOT . "/lib/FastRouter/src/bootstrap.php";

$dispatcher = FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
    //@Todo: Add rules here. Some examples follow
    $r->addRoute('GET', '/user/{name}/{id:[0-9]+}', 'handler0');
    $r->addRoute('GET', '/user/{id:[0-9]+}', 'handler1');
    $r->addRoute('GET', '/user/{name}', 'handler2');
});

$requestMethod = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "GET";
$uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";

$routeInfo = $dispatcher->dispatch($requestMethod, $uri);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        //@Todo: Implement 404 page!
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        //@Todo: Implement 405 page!
        break;
    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        //@Todo: Do stuff with $handler and $vars.
    break;
}