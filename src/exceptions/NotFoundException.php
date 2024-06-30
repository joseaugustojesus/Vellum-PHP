<?php

namespace src\exceptions;

use Exception;
use src\support\Notification;
use Throwable;

// Definição da classe da exceção personalizada NotFoundException
class NotFoundException extends Exception
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
