<?php

namespace src\repositories;

use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;
use src\database\Database;
use src\database\Model;
use src\interfaces\NexusRepositoryInterface;



class NexusRepository implements NexusRepositoryInterface
{

    private PDO $db;
    private string $table;
    private string $queryString;
    /** @var array<string, mixed> */
    private array $bind;
    private Model $model;
    private bool $selectIsOne;

    public function __construct()
    {
        $this->db = (new Database)->connect();
    }

    /**
     * @param string $table
     * @return self
     */
    function insert(string $table): self
    {
        $this->queryString = "INSERT INTO {$table}";
        return $this;
    }

    /**
     * @param array<string, mixed> $binds
     * @return self
     */
    function values(array $binds = []): self
    {
        $binds["id"] = Uuid::uuid4()->toString();
        $this->bind = $binds;
        $keys = implode(", ", array_keys($binds));
        $keysUsingInBind = ":" . implode(", :", array_keys($binds));
        $this->queryString .= " ({$keys}) VALUES ({$keysUsingInBind})";

        return $this;
    }


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function where(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " WHERE {$column} {$operation} :{$columnWithoutTable}";
        $this->bind[$columnWithoutTable] = $value;
        return $this;
    }


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function andWhere(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " AND {$column} {$operation} :{$columnWithoutTable}";
        $this->bind[$columnWithoutTable] = $value;
        return $this;
    }

    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function orWhere(string $column, string $operation, mixed $value): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $this->queryString .= " OR {$column} {$operation} :{$column}";
        $this->bind[$column] = $value;
        return $this;
    }


    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function andIn(string $column, array $values): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $params = [];
        foreach ($values as $key => $value) {
            $params[":{$column}{$key}"] = $value;
            $this->bind[":{$column}{$key}"] = $value;
        }
        $paramsIn = implode(", ", array_keys($params));

        $this->queryString .= " AND {$column} IN ({$paramsIn})";

        return $this;
    }

    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function whereIn(string $column, array $values): self
    {
        $columnWithoutTable = $column;
        if (str_contains($column, '.'))
            [$table, $columnWithoutTable] = explode(".", $column);

        $params = [];
        foreach ($values as $key => $value) {
            $params[":{$column}{$key}"] = $value;
            $this->bind[":{$column}{$key}"] = $value;
        }
        $paramsIn = implode(", ", array_keys($params));


        $this->queryString .= " WHERE {$column} IN ({$paramsIn})";
        return $this;
    }

    /**
     * @param string $column
     * @return self
     */
    function whereIsNull(string $column): self
    {
        $this->queryString .= " WHERE {$column} IS NULL";
        return $this;
    }

    /**
     * @param string $column
     * @return self
     */
    function whereIsNotNull(string $column): self
    {
        $this->queryString .= " WHERE {$column} IS NOT NULL";
        return $this;
    }

    /**
     * @return object|array<int, object>|bool
     */
    function make(): object|array|bool
    {
        try {
            $firstWord = strstr($this->queryString, ' ', true);
            if (!is_string($firstWord)) {
                return false;
            }
            $isSelect = strtolower(trim($firstWord)) === "select";

            if (!$isSelect) {
                $stmt = $this->db->prepare($this->queryString);
                return $stmt->execute($this->bind ?? []);
            } else {
                if ($this->selectIsOne)
                    $this->limit();


                $stmt = $this->db->prepare($this->queryString);
                $stmt->execute($this->bind ?? []);


                if (isset($this->model))
                    $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this->model));
                else
                    $stmt->setFetchMode(PDO::FETCH_OBJ);

                if ($this->selectIsOne) {
                    return $stmt->fetch();
                } else {
                    return $stmt->fetchAll();
                }
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param array<int, string> $fields
     * @param bool $selectIsOne - false as default
     */
    function select(array $fields = [], bool $selectIsOne = false): self
    {
        if (empty($fields))
            $fieldsInString = "{$this->table}.*";
        else
            $fieldsInString = implode(', ', $fields);

        $this->selectIsOne = $selectIsOne;
        $this->queryString = "SELECT {$fieldsInString} FROM {$this->table}";
        return $this;
    }


    /**
     * @param array<int, string> $fields
     * @return self
     */
    function selectOne(array $fields = []): self
    {
        return $this->select($fields, true);
    }

    /**
     * @param int $limit - 1 as default
     */
    function limit(int $limit = 1): self
    {
        $this->queryString .= " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function innerJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " INNER JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function leftJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " LEFT JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function rightJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " RIGHT JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function fullJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self
    {
        $this->queryString .= " FULL OUTER JOIN {$table} ON {$this->table}.{$firstColumn} {$operation} {$table}.{$secondColumn}";
        return $this;
    }

    /**
     * @param Model $model
     * @return self
     */
    function model(Model $model): self
    {
        $this->model = $model;
        $this->table = $this->model->getTable();
        return $this;
    }

    /**
     * @param string $table
     * @return self
     */
    function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    function update(array $data): self
    {
        $this->queryString = "UPDATE {$this->table} SET ";
        foreach ($data as $key => $value) {
            $this->queryString .= "{$key} = :{$key}, ";
        }
        $this->queryString = rtrim($this->queryString, ", ");
        $this->bind = $data;
        return $this;
    }

    /**
     * @return bool
     */
    function save(): bool
    {
        $binds = array_diff_key(get_object_vars($this->model), array_flip(["table"]));
        /** @var bool */
        $saved = $this->insert($this->model->getTable())->values($binds)->make();
        return $saved;
    }

    /**
     * @return self
     */
    function delete(): self
    {
        $this->queryString = "DELETE FROM {$this->table}";
        return $this;
    }

    /**
     * @return self
     */
    function softDelete(): self
    {
        $this->queryString = "UPDATE {$this->table} SET deleted_at = NOW()";
        return $this;
    }

    /**
     * @return ?PDO
     */
    function raw(): ?PDO
    {
        return $this->db;
    }

    function transactionBegin(): self
    {
        $this->db->beginTransaction();
        return $this;
    }

    function transactionCommit(): bool
    {
        $this->db->commit();
        return true;
    }

    function transactionRollback(): bool
    {
        $this->db->rollback();
        return false;
    }
}
