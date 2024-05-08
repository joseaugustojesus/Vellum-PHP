<?php

namespace src\support;

class Uri
{
    /**
     * @return string
     */
    public static function get(): string
    {
        /** @var string */
        $urlParsed = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = array_filter(explode('/', trim($urlParsed)));
        return $uri = '/' . implode('/', $uri);
    }
}
