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

$routeCollection->addRoute('article/add', new Route(
    'article/add',
    'HomeController@add'
));

Router::setRouteCollection($routeCollection);
