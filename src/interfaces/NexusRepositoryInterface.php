<?php

namespace src\interfaces;

use PDO;
use src\database\Model;

interface NexusRepositoryInterface
{
    /**
     * @param string $table
     * @return self
     */
    function insert(string $table): self;

    /** 
     * @param array<string, mixed> $binds 
     * @return self
     */
    function values(array $binds = []): self;

    /**
     * @return object|array<int, object>|bool
     */
    function make(): object|array|bool;

    /**
     * @param Model $model
     * @return self
     */
    function model(Model $model): self;

    /**
     * @param int $limit - 1 as default
     */
    function limit(int $limit = 1): self;

    /**
     * @return bool
     */
    function save(): bool;

    /**
     * @param array<int, string> $fields
     * @return self
     */
    function selectOne(array $fields = []): self;

    /**
     * @param array<int, string> $fields
     * @param bool $isOne
     * @return self
     */
    function select(array $fields, bool $isOne): self;


    /**
     * @param array<string, string> $data
     * @return self
     */
    function update(array $data): self;

    /**
     * @return self
     */
    function delete(): self;

    /**
     * @return ?PDO
     */
    function raw(): ?PDO;

    /**
     * @return self
     */
    function softDelete(): self;

    /**
     * @param string $column
     * @return self
     */
    function whereIsNull(string $column): self;

    /**
     * @param string $column
     * @return self
     */
    function whereIsNotNull(string $column): self;

    /**
     * @return self
     */
    function transactionBegin(): self;

    /**
     * @return bool
     */
    function transactionCommit(): bool;

    /**
     * @return bool
     */
    function transactionRollback(): bool;

    /**
     * @param string $table
     * @return self
     */
    function setTable(string $table): self;


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function where(string $column, string $operation, mixed $value): self;



    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function andWhere(string $column, string $operation, mixed $value): self;


    /**
     * @param string $column
     * @param string $operation
     * @param mixed $value
     * @return self
     */
    function orWhere(string $column, string $operation, mixed $value): self;


    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function andIn(string $column, array $values): self;


    /**
     * @param string $column
     * @param array<string, mixed> $values
     * @return self
     */
    function whereIn(string $column, array $values): self;


    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function innerJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self;


    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function leftJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self;



    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function rightJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self;

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $operation
     * @param string $secondColumn
     * @return self
     */
    function fullJoin(string $table, string $firstColumn, string $operation, string $secondColumn): self;
}
