<?php

namespace src\controllers;

use src\database\Model;
use src\database\models\Example;
use src\support\View;

class ExampleController
{
   
    function example(): View
    {
        // (new \src\services\ExampleService)->example();
        // dump("this is example controller saying hello for you! >:D");
        return View::render("404", []);
    }
}
