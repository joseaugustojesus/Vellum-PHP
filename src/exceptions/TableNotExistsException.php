<?php

namespace src\exceptions;

use Exception;
use Throwable;


class TableNotExistsException extends Exception
{
    protected $httpStatusCode;

    // Construtor que permite definir a mensagem, código HTTP e código de erro
    public function __construct($message = "", $httpStatusCode = 404, $code = 0, Throwable $previous = null)
    {
        $this->httpStatusCode = $httpStatusCode;
        parent::__construct($message, $code, $previous);
    }

    // Método para obter o código HTTP associado
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
}
