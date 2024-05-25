<?php

namespace src\controllers;

use src\support\View;

class ExampleController
{
   
    function example(): View
    {
        (new \src\services\ExampleService)->example();
        // dump("this is example controller saying hello for you! >:D");
        var_dump("Im Using xXdebug");
        return View::render("404", []);
    }
}
