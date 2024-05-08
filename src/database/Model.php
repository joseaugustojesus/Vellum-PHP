<?php

namespace src\database;

class Model
{

    protected string $table;

    /**
     * Method responsible for filling the model attributes according to the informed array
     * 
     * @param array<string, mixed> $data - indexed content that will be filled as attributes of the model
     * 
     * @return self
     */
    public function set(array $data): self
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
        return $this;
    }


    /**
     * @return string
     */
    function getTable(): string
    {
        return $this->table;
    }
}
