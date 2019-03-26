<?php

namespace Blaj\BlajMVC\Core;

use Blaj\BlajMVC\Core\Routing\Router;
use Blaj\BlajMVC\Core\Utils\FlashMessage;

abstract class Controller extends ACL
{
    public $flashMessage;

    public function __construct()
    {
        $this->flashMessage = new FlashMessage();
    }

    public function redirect($url, $data = false)
    {
        if (!$data)
            header('location: ' . $url);

        $collection = Router::getRouteCollection();
        $route = $collection->getRoute($url);
        if (isset($route)) {
            $url = $route->generateUrl($data);
            header('location: ' . $url);
        }
    }

    public function path($name, $data)
    {
        $collection = Router::getRouteCollection();
        $route = $collection->getRoute($name);
        if (isset($route))
            return $route->generateUrl($data);

        return false;
    }
}
