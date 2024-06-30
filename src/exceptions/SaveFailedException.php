<?php

namespace src\exceptions;

use Exception;
use Throwable;


class SaveFailedException extends Exception
{
     // Construtor que permite definir a mensagem, código HTTP e código de erro
     public function __construct($message = "", $code = 0, Throwable $previous = null)
     {
         parent::__construct($message, $code, $previous);
     }
}
