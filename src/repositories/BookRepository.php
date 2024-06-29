<?php

namespace src\repositories;

use src\repositories\NexusRepository;

class BookRepository extends NexusRepository
{

    function store(array $data)
    {
        $this->table("books")->insert($data)->finish();
    }
}
