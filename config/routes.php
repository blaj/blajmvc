<?php

use Blaj\BlajMVC\Core\Routing\RouteCollection;
use Blaj\BlajMVC\Core\Routing\Route;
use Blaj\BlajMVC\Core\Routing\Router;

$routeCollection = new RouteCollection();

$routeCollection->addRoute('home', new Route(
    '',
    'HomeController@index'
));

$routeCollection->addRoute('article/read', new Route(
    'article/{id}',
    'HomeController@read',
    [
        'id' => '\d+'
    ]
));

Router::setRouteCollection($routeCollection);
