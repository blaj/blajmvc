<?php

use Blaj\BlajMVC\Core\Routing\RouteCollection;
use Blaj\BlajMVC\Core\Routing\Route;
use Blaj\BlajMVC\Core\Routing\Router;

$routeCollection = new RouteCollection();

$routeCollection->addRoute('home', new Route(
    '',
    'HomeController@index'
));

$routeCollection->addRoute('home/show', new Route(
    'home/{id}',
    'HomeController@show',
    [
        'id' => '\d+'
    ]
));

Router::setRouteCollection($routeCollection);
