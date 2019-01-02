<?php

namespace Blaj\BlajMVC\Core\Routing;

class Route
{
    protected $path;

    protected $controllerFile;

    protected $controllerClass;

    protected $controllerAction;

    protected $params;

    protected $defaults;

    public function __construct($path, $config, $params = [], $defaults = [])
    {
        $this->path = HTTP_SERVER . $path;

        $config = explode('@', $config);

        $this->controllerFile = DIR_CONTROLLER . $config[0] . '.php';
        $this->controllerClass = '\Blaj\BlajMVC\Controller\\' . $config[0];
        $this->controllerAction = $config[1];
        $this->params = $params;
        $this->defaults = $defaults;
    }

    public function generateUrl($data)
    {
        if (is_array($data) && sizeof($data)>0) {
            $key_data = array_keys($data);
            foreach ($key_data as $key) {
                $data2['{' . $key . '}'] = $data[$key];
            }
            $url = str_replace(array('?', '(', ')'), array('', '', ''), $this->path);
            return str_replace(array_keys($data2), $data2, $url);
        } else {
            $url=preg_replace("#<[a-zA-Z0-9]*>#", '', $this->path, 1);
            return str_replace(array('?', '(', ')'), array('', '', ''), $url);
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getControllerFile()
    {
        return $this->controllerFile;
    }

    public function setControllerFiler($controllerFile)
    {
        $this->controllerFile = $controllerFile;
    }

    public function getControllerClass()
    {
        return $this->controllerClass;
    }

    public function setControllerClass($controllerClass)
    {
        $this->controllerClass = $controllerClass;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }

    public function setControllerAction($controllerAction)
    {
        $this->controllerAction = $controllerAction;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }

    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }
}
