<?php

namespace src\database;

use PDO;

class LocalInstance
{
    private PDO $db;
    function __construct()
    {
        $this->db = (new Database)->connect();
    }

    function db()
    {
        return $this->db;
    }
}
