<?php

namespace src\exceptions;

use Exception;
use src\support\Notification;
use Throwable;

// Definição da classe da exceção personalizada NotFoundException
class NotFoundException extends Exception
{
    // Construtor que permite definir a mensagem, código HTTP e código de erro
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
