<?php


namespace src\routes;

use src\controllers\BookController;
use src\middlewares\need2BeLoggedIn;

$router = new Router;


$router->get("/", BookController::class, "list", [need2BeLoggedIn::class]);
$router->get("/books", BookController::class, "list", [need2BeLoggedIn::class]);
$router->get("/books/new", BookController::class, "create", [need2BeLoggedIn::class]);


return $router->init();
