<?php

namespace src\core;

use DI\Container;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use src\support\Json;
use src\support\Redirect;
use src\support\RequestType;
use src\support\Uri;
use src\support\View;

class Controller
{


    public function __construct(string $router)
    {
        list($controller, $method) = $this->certifyRouter($router);
        $this->certifyIfControllerExists($controller);
        $this->certifyIfMethodExists($controller, $method);
        $this->execute($router, $controller, $method);
    }


    public function execute(string $router, string $controller, string $method): void
    {
        $params = $this->getParamsInRoute($router);
        /** @var Container */
        $container = $this->startContainerInjection();
        $controllerObject = $container->get($controller);


        /** @var Redirect|View|Json|null */
        $response = $this->handleRequest($controller, $method, $controllerObject, $container, $params);



        if (!$response)
            dd("Error: Missing return in your controller: {$controller}");


        if ($response instanceof Redirect)
            redirect($response::$redirect);



        if (in_array(true, [
            $response instanceof View,
            $response instanceof Json
        ])) {
            echo $response::$isString;
            die;
        }
    }

    /**
     * @param string $router
     * @return array<int, string>
     */
    private function certifyRouter(string $router): array
    {
        if (substr_count($router, '@') <= 0)
            throw new Exception("A rota está registrada com o formato errado");

        return explode('@', $router);
    }

    private function certifyIfControllerExists(string $controller): void
    {
        if (!class_exists($controller))
            throw new Exception("O controller ({$controller}) não existe");
    }

    /**
     * @param string $controller
     * @param string $method
     */
    private function certifyIfMethodExists(string $controller, string $method): void
    {
        if (!method_exists($controller, $method)) {
            throw new Exception("O método ({$method}) não existe.");
        }
    }

    private function startContainerInjection(): object
    {
        $container = require_once(__DIR__ . "/container.php");
        return $container;
    }

    /**
     * @param string $router_
     * @return array<int, mixed>|bool
     */
    private function getParamsInRoute(string $router_): array|bool
    {
        $uri = Uri::get();
        $requestMethod = RequestType::get();
        $routes = require($_ENV["APP_PATH"] . "/src/routes/Routes.php");
        $routesClean = $this->clearRoutesWithoutMiddlewares($routes, $requestMethod);


        $router = array_search($router_, $routesClean[$requestMethod]);
        if ($router) {

            $explodeUri = array_values(array_filter(explode('/', $uri)));
            $explodeRouter = array_values(array_filter(explode('/', $router)));


            $params = [];
            foreach ($explodeRouter as $index => $routerSegment) {
                if (
                    isset($explodeUri[$index])
                    && $routerSegment !== $explodeUri[$index]
                )
                    $params[$index] = $explodeUri[$index];
            }


            return $params;
        }

        return false;
    }

    /**
     * @param string $controller
     * @param string $method
     * @param object $controllerObject
     * @param Container $container
     * @param array<int, mixed>|bool $params
     */
    private function handleRequest(string $controller, string $method, object $controllerObject, $container, array|bool $params): ?object
    {

        if (class_exists($controller)) {
            $reflection = new ReflectionClass($controller);
            $parameters = $reflection->getMethod($method)->getParameters();

            $params = $params ?: [];
            $parametersInterface = [];
            $parametersNotInterface = [];

            if ($parameters) {
                foreach ($parameters as $parameterFromMethod) {
                    /** @var ReflectionNamedType */
                    $reflectionNamedType = $parameterFromMethod->getType();
                    $parameterNameAbsolute = $reflectionNamedType->getName();

                    if (str_contains($parameterNameAbsolute, "interface")) {
                        $parametersInterface[] = $container->get($parameterNameAbsolute);
                    } else {
                        if (!in_array($parameterNameAbsolute, ["string", "int", "bool", "float"])) {
                            $parametersNotInterface[] = (new $parameterNameAbsolute());
                        }
                    }
                }
                $response = $controllerObject->$method(...$parametersInterface, ...$parametersNotInterface, ...$params);
            } else
                $response = $controllerObject->$method(...$params);

            return $response;
        }
        return null;
    }


    /**
     * @param array<string, array<string, string>> $routes
     * @param string $requestMethod
     * @return array<string, array<string, string>>
     */
    private function clearRoutesWithoutMiddlewares(array $routes, string $requestMethod): array
    {
        foreach ($routes[$requestMethod] as $routeKey => $routeValue) {
            if ($position = strpos($routeValue, ":")) {
                $routes[$requestMethod][$routeKey] = mb_substr(
                    $routeValue,
                    0,
                    $position
                );
            }else
                $routes[$requestMethod][$routeKey] = $routeValue;
        }
        return $routes;
    }
}
