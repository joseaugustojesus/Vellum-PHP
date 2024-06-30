<?php

namespace src\repositories;

use PDO;
use PDOException;
use stdClass;

class NexusRepository
{

    private PDO $db;
    private string $table;
    private string $queryString;
    /** @var array<string, mixed> */
    private array $bind;
    private bool $selectIsOne;

    function configDatabase(PDO $db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    function insert(array $data): self
    {
        $this->queryString = "INSERT INTO {$this->table}";
        $this->values($data);
        return $this;
    }

    /**
     * @param array<string, mixed> $binds
     * @return self
     */
    function values(array $binds = []): self
    {
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
    function finish(): object|array|bool
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



                $stmt->setFetchMode(PDO::FETCH_OBJ);

                if ($this->selectIsOne) {
                    return $stmt->fetch();
                } else {
                    return $stmt->fetchAll();
                }
            }
        } catch (PDOException $e) {
            dd($e);
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
     * @param string $table
     * @return self
     */
    function table(string $table): self
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


    /**
     * @param int $offset
     */
    function offset(int $offset): self
    {
        $this->queryString .= " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param string $column
     * @param string $type
     */
    function order(string $column, string $type): self
    {
        $this->queryString .= " ORDER BY {$column} {$type}";
        return $this;
    }


    function pagination(int $rowsPerPage = 5): stdClass
    {
        $stdclass = new stdClass();
        $raw = $this->finish();
        $pagina = (isset($_GET['page']) ? $_GET['page'] : 1) - 1;
        $offset = $pagina * $rowsPerPage;
        $paginated = $this->order("id", "DESC")->limit($rowsPerPage)->offset($offset)->finish(0);
        $quantitiesOfPages = ceil(count($raw) / $rowsPerPage);
        $links = pagination($quantitiesOfPages);


        $stdclass->raw = $raw;
        $stdclass->currentPage = $pagina  + 1;
        $stdclass->offset = $offset;
        $stdclass->paginated = $paginated;
        $stdclass->quantitiesOfPages = $quantitiesOfPages;
        $stdclass->quantitiesPerPage = $rowsPerPage;
        $stdclass->links = $links;

        return $stdclass;
    }
}
