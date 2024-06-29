<?php

namespace src\support;



final class Redirect
{

    public static string $isString;
    public static string $redirect;


    /**
     * This method is responsible for performing the URI REDIRECT
     * 
     * @param string $uri
     * @return Redirect
     */
    public static function to(string $uri): Redirect
    {
        self::$redirect = route($uri);
        return new static;
    }
}
