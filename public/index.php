<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once '../config/config.php';
require_once DIR_VENDOR.'autoload.php';
require_once '../config/routes.php';
require_once '../config/translations.php';

use Blaj\BlajMVC\Core\Utils\Session;
use Blaj\BlajMVC\Core\Routing\Router;

Session::start(3600);

$router = new Router();
$router->setUrl('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);

if ($router->run()) {
    require_once($router->getControllerFile());

    $controllerClass = $router->getControllerClass();
    $controllerAction = $router->getControllerAction();

    $controller = new $controllerClass;
    echo $controller->$controllerAction();
} else {
    http_response_code(404);
    echo '<h1>404 not found</h1>';
}
