<?php

namespace src\controllers;

use PDO;
use src\support\View;

class BookController
{

    function list(): View
    {
        return View::render("books.list", []);
    }


    function create()
    {
        return View::render("books.create", []);
    }
}
