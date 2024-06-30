<?php

namespace src\traits;

use PDO;
use stdClass;

trait Repository
{
    function configDatabase(PDO $db)
    {
        $this->nexus->db = $db;
        return $this;
    }


    /**
     * @param array $data
     * @return bool
     */
    function store(array $data): bool
    {
        return $this->nexus->table($this->table)->insert($data)->finish();
    }

    /**
     * @return stdClass
     */
    function pagination(): stdClass
    {
        return $this->nexus->table($this->table)->select()->pagination();
    }


    function getById(int $id): stdClass|bool
    {
        return $this->nexus->table($this->table)->selectOne()->where("id", "=", $id)->finish();
    }

    /**
     * @param int $id
     * @return bool
     */
    function destroy(int $id): bool
    {
        return $this->nexus->table($this->table)->delete()->where('id', "=", $id)->finish();
    }

    function update(int $id, array $data)
    {
        return $this->nexus->table($this->table)->update($data)->where("id", "=", $id)->finish();
    }
}
