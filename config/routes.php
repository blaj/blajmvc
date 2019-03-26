<?php

use Blaj\BlajMVC\Core\Routing\RouteCollection;
use Blaj\BlajMVC\Core\Routing\Route;
use Blaj\BlajMVC\Core\Routing\Router;

$routeCollection = new RouteCollection();

$routeCollection->addRoute('example_home/index', new Route(
    '',
    'ExampleHomeController@index'
));

$routeCollection->addRoute('example_home/show', new Route(
    'show/{id}',
    'ExampleHomeController@show',
    [
        'id' => '\d+'
    ]
));

$routeCollection->addRoute('example_user/index', new Route(
    'user',
    'ExampleUserController@index'
));

$routeCollection->addRoute('example_user/login', new Route(
    'user/login',
    'ExampleUserController@login'
));

$routeCollection->addRoute('example_user/logout', new Route(
    'user/logout',
    'ExampleUserController@logout'
));

Router::setRouteCollection($routeCollection);
