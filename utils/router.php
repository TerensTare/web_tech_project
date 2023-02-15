<?php

require_once 'utils/route.php';

class Router
{
    private array $routes;
    private Route $wildcard;

    private function __construct(array $routes = [], Route|null $default = null)
    {
        $this->routes = $routes;
        $this->wildcard = $default ?? new class extends Route {
            public function enter()
            {
                http_response_code(404);
            }
        };
    }

    public static function withRoutes(array $routes, Route|null $default = null)
    {
        return new Router($routes, $default);
    }

    public static function create()
    {
        return new Router();
    }

    public function route(string $path, Route $route)
    {
        $this->routes[$path] = $route;
        return $this;
    }

    public function enter(string $path)
    {
        if (array_key_exists($path, $this->routes)) {
            $this->routes[$path]->enter();
        } else {
            $this->wildcard->enter();
        }
    }

    public function default (Route $route)
    {
        $this->wildcard = $route;
        return $this;
    }

    public function resolve()
    {
        $this->enter($_SERVER['REQUEST_URI']);
    }
}

?>