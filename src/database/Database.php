<?php

namespace src\database;

use Exception;
use PDO;
use PDOException;


class Database
{

    private ?PDO $pdo;

    public function __construct(
        private ?string $typeConnection = null,
        private ?string $host = null,
        private ?string $dbname = null,
        private ?string $username = null,
        private ?string $password = null,
        private ?string $service = null,
        private ?string $server = null
    ) {
        $this->typeConnection = $typeConnection ?? $_ENV["DB_TYPE"];
        $this->host = $host ?? $_ENV["DB_HOST"];
        $this->dbname = $dbname ?? $_ENV["DB_BASE"];
        $this->username = $username ?? $_ENV["DB_USER"];
        $this->password = $password ?? $_ENV["DB_PASSWD"];
        $this->service = $service;
        $this->server = $server;
    }

    /**
     * Method performs the database connection
     * @return PDO
     */
    public function connect(): PDO
    {
        try {
            $this->pdo = new PDO($this->getDsn(), $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            dd("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Obtains the type of DNS according to the informed connection
     * 
     * @return string
     */
    private function getDsn(): string
    {
        switch ($this->typeConnection) {
            case 'mysql':
                return "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            case 'sqlserver':
                return "sqlsrv:Server={$this->host};Database={$this->dbname}";
            case 'informix':
                return "informix:host={$this->host}; service={$this->service}; database={$this->dbname}; server={$this->server}; protocol=olsoctcp";
            default:
                throw new Exception("Tipo de conexão inválido: {$this->typeConnection}");
        }
    }
}
