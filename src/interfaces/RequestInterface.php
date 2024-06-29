<?php

namespace src\interfaces;

interface RequestInterface
{
     /**
      * This method returns all inputs except the token
      * 
      * @param ?string $key
      * @return array<mixed, mixed>|string
      */
     public function get(?string $key = null): array|string;
}
