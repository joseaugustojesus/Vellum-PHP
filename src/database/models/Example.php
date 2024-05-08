<?php

namespace src\database\models;

use src\database\Model;

class Example extends Model
{
    
    public string $table = 'table_example';
    
    public string $id;
    public string $name;

    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
}
