<?php

namespace src\repositories;

use src\repositories\NexusRepository;
use stdClass;

class BookRepository extends NexusRepository
{

    function store(array $data)
    {
        $this->table("books")->insert($data)->finish();
    }

    function get(): stdClass
    {
        return $this->table("books")->select()->pagination();
    }
}
