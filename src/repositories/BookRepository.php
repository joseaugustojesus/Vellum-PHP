<?php

namespace src\repositories;

use src\repositories\NexusRepository;
use src\traits\Repository;

class BookRepository
{
    private string $table;

    function __construct(
        private NexusRepository $nexus
    ) {
        $this->table = 'books';
    }

    use Repository;
}
