<?php

namespace src\core;

use Exception;

class Bootstrap
{

    public static function run(): void
    {
        try {
            $classMethodAndMiddlewares = (new Router)->get();

            if (!$classMethodAndMiddlewares)
                throw new Exception("A rota informada não está disponível", 500);

            self::executeMiddlewares($classMethodAndMiddlewares);

            (new Controller(self::getOnlyClassAndMethod($classMethodAndMiddlewares)));
        } catch (Exception $e) {
            dd("Error ({$e->getCode()}):" . $e->getMessage());
        }
    }


    private static function getOnlyClassAndMethod(string $router): string
    {
        [$classAndMethod] = explode(":", $router);
        return $classAndMethod;
    }


    private static function executeMiddlewares(string $classAndMethod): void
    {
        foreach (self::getMiddlewaresFromRoute($classAndMethod) as $middleware) {
            new $middleware();
        }
    }


    /**
     * @param string $classAndMethod
     * 
     * @return array<int, string>
     */
    private static function getMiddlewaresFromRoute(string $classAndMethod): array
    {
        $middlewares = [];
        if (str_contains($classAndMethod, ':')) {
            $middlewares =  array_filter(
                array_filter(
                    explode(":", $classAndMethod),
                    function ($r) {
                        return !str_contains($r, '@');
                    }
                )
            );
        }
        return $middlewares;
    }
}
