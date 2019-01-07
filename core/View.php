<?php

namespace Blaj\BlajMVC\Core;

use Blaj\BlajMVC\Core\Routing\Router;

class View
{
    protected $data = [];
    private static $var = [];

    private $file;

    function __construct($templateFile)
    {
        $this->file = $templateFile;
    }

    function __toString()
    {
        if (!file_exists(DIR_TEMPLATE . $this->file)) return '';

        foreach (array_merge(self::$var, $this->data) as $name => $value) {
            if ($name != 'this')
                $$name = $value;
        }

        unset($name, $value);
        ob_start();
        require_once DIR_TEMPLATE . $this->file;
        return ob_get_clean();
    }

    public function __get($name)
    {
        return array_key_exists($name, $this->data) ? $this->data[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function get($name)
    {
        return array_key_exists($name, $this->data) ? $this->data[$name] : null;
    }

    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function path($name, $data = null)
    {
        $collection = Router::getRouteCollection();
        $route = $collection->getRoute($name);
        if (isset($route))
            return $route->generateUrl($data);

        return false;
    }

    public function asset($file)
    {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/';

        return $url . $file;
    }
}
