<?php

namespace Blaj\BlajMVC\Core\Routing;

class Router
{
    protected static $routeCollection;

    protected $url;

    protected $controllerFile;

    protected $controllerClass;

    protected $controllerAction;

    public function __construct()
    {

    }

    public function run()
    {
        foreach (self::$routeCollection->getAll() as $route) {
            if ($this->matchRoute($route)) {
                $this->setGetData($route);
                return true;
            }
        }

        return false;
    }

    public function matchRoute(Route $route)
    {
        $params = array();
        $key_params = array_keys($route->getParams());
        $value_params = $route->getParams();

        foreach ($key_params as $key) {
            $params['{' . $key . '}'] = $value_params[$key];
        }

        $url = $route->getPath();
        $url = str_replace(array_keys($params), $params, $url);
        $url = preg_replace('/<\w+>/', '.*', $url);

        preg_match("#^$url$#", $this->url, $results);

        if ($results) {
            $this->url=str_replace(array($this->strlcs($url, $this->url)), array(''), $this->url);
            $this->controllerFile = $route->getControllerFile();
            $this->controllerClass = $route->getControllerClass();
            $this->controllerAction = $route->getControllerAction();

            return true;
        }

        return false;
    }

    protected function setGetData(Route $route)
    {
        $routePath = str_replace(array('(', ')'), array('', ''), $route->getPath());
        $trim = explode('<', $routePath);
        $parsed_url = str_replace(array(HTTP_SERVER), array(''), $this->url);
        $parsed_url = preg_replace("#$trim[0]#", '', $parsed_url, 1);

        foreach ($route->getParams() as $key => $param) {
            if ($parsed_url[0] == '/') {
                $parsed_url = substr($parsed_url, 1);
            }
            preg_match("#$param#", $parsed_url, $results);
            if (!empty($results[0])) {
                $_GET[$key] = $results[0];
                $temp_url = explode($results[0], $parsed_url, 2);
                $parsed_url = $temp_url[1];
            }
        }

        foreach ($route->getDefaults() as $key => $default) {
            if (!isset($_GET[$key])) {
                $_GET[$key] = $default;
            }
        }
    }

    /**
     * Zwraca część wspólną ciągów
     * @param string $str1 Ciąg 1
     * @param string $str2 Ciąg 2
     * @return string część wspólna
     */
    protected function strlcs($str1, $str2)
    {
        $str1Len = strlen($str1);
        $str2Len = strlen($str2);
        $ret = array();

        if ($str1Len == 0 || $str2Len == 0)
            return $ret;

        $CSL = array();
        $intLargestSize = 0;

        for ($i = 0; $i < $str1Len; $i++) {
            $CSL[$i] = array();
            for ($j = 0; $j < $str2Len; $j++) {
                $CSL[$i][$j] = 0;
            }
        }

        for ($i = 0; $i < $str1Len; $i++) {
            for ($j = 0; $j < $str2Len; $j++) {
                if ($str1[$i] == $str2[$j]) {
                    if ($i == 0 || $j == 0)
                        $CSL[$i][$j] = 1;
                    else
                        $CSL[$i][$j] = $CSL[$i - 1][$j - 1] + 1;

                    if ($CSL[$i][$j] > $intLargestSize) {
                        $intLargestSize = $CSL[$i][$j];
                        $ret = array();
                    }
                    if ($CSL[$i][$j] == $intLargestSize)
                        $ret[] = substr($str1, $i - $intLargestSize + 1, $intLargestSize);
                }
            }
        }
        if (isset($ret[0])) {
            return $ret[0];
        } else {
            return '';
        }
    }

    public function getControllerFile()
    {
        return $this->controllerFile;
    }

    public function setControllerFile($controllerFile)
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $url = explode('?', $url);
        $this->url = $url[0];
    }

    public static function setRouteCollection($routeCollection = null)
    {
        if ($routeCollection != null)
            self::$routeCollection = $routeCollection;
    }

    public static function getRouteCollection()
    {
        return self::$routeCollection;
    }

}
