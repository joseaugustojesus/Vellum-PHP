<?php


namespace src\routes;

use src\controllers\BookController;
use src\middlewares\need2BeLoggedIn;

$router = new Router;


$router->get("/", BookController::class, "list", [need2BeLoggedIn::class]);
$router->get("/books", BookController::class, "list", [need2BeLoggedIn::class]);
$router->get("/books/new", BookController::class, "create", [need2BeLoggedIn::class]);
$router->post("/books/store", BookController::class, "store", [need2BeLoggedIn::class]);
$router->get("/books/delete/[0-9]+", BookController::class, "delete", [need2BeLoggedIn::class]);
$router->get("/books/edit/[0-9]+", BookController::class, "edit", [need2BeLoggedIn::class]);
$router->post("/books/update", BookController::class, "update", [need2BeLoggedIn::class]);


return $router->init();
