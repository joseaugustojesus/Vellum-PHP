<?php

namespace src\middlewares;



class need2BeLoggedIn
{
    function __construct()
    {
        $this->execute();
    }

    function execute(): bool
    {
        if (!isset($_SESSION['user_id'])) {
        //    redirect("/login");
        }
        return true;
    }
}
