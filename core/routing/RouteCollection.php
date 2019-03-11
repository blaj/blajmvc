<?php

namespace Blaj\BlajMVC\Core\Routing;

class RouteCollection
{
    protected $routes;

    public function addRoute($name, Route $route)
    {
        $this->routes[$name] = $route;
    }

    public function getRoute($name)
    {
        if (array_key_exists($name, $this->routes)) {
            return $this->routes[$name];
        } else {
            return null;
        }
    }

    public function getAll()
    {
        return $this->routes;
    }
}
