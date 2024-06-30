<?php

namespace src\repositories;

use src\repositories\NexusRepository;
use stdClass;

class BookRepository extends NexusRepository
{

    /**
     * @param array $data
     * @return bool
     */
    function store(array $data): bool
    {
        return $this->table("books")->insert($data)->finish();
    }

    /**
     * @return stdClass
     */
    function get(): stdClass
    {
        return $this->table("books")->select()->pagination();
    }

    /**
     * @param int $id
     * @return bool
     */
    function destroy(int $id): bool
    {
        return $this->table('books')->delete()->where('id', "=", $id)->finish();
    }
}
