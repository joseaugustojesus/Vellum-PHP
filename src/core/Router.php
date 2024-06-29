<?php

namespace src\core;

use src\support\RequestType;
use src\support\Uri;

class Router
{

    private string $uri;
    private string $method;
    /** @var array<string, array<string, string>> */
    private array $routesRegistered;

    public function __construct()
    {
        $this->uri = Uri::get();
        $this->method = RequestType::get();
        $this->routesRegistered = require($_ENV["APP_PATH"] . "/src/routes/Routes.php");
    }

    /**
     * Method for obtaining simple routes
     * 
     * @return string|null
     */
    private function simpleRouter(): string|null
    {
        return $this->routesRegistered[$this->method][$this->uri] ?? null;
    }


    /**
     * Method obtains dynamic routes
     * 
     * @return string|null
     */
    private function dynamicRouter(): string|null
    {
        $routerRegisteredFound = null;

        foreach ($this->routesRegistered[$this->method] as $index => $route) {
            $regex = str_replace('/', '\/', ltrim($index, '/'));
            if ($index !== '/' and preg_match("/^$regex$/", ltrim($this->uri, '/')))
                return $route;
        }
        
        return $routerRegisteredFound;
    }


    /**
     * Processes the beginning to get simple or dynamic routes
     * 
     * @return string|null
     */
    public function get(): string|null
    {
        return $this->simpleRouter() ?: $this->dynamicRouter();
    }
}
