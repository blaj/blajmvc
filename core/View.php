<?php

namespace Blaj\BlajMVC\Core;

use Blaj\BlajMVC\Core\Routing\Router;
use Blaj\BlajMVC\Core\Utils\Translations;
use Blaj\BlajMVC\Core\Utils\FlashMessage;

class View
{
    public $flashMessage;

    protected $data = [];
    private static $var = [];

    private $file;

    function __construct($templateFile)
    {
        $this->file = $templateFile;
        $this->flashMessage = new FlashMessage();
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

    public function path(string $name, array $data = null): string
    {
        $collection = Router::getRouteCollection();
        $route = $collection->getRoute($name);
        if (isset($route))
            return $route->generateUrl($data);

        return null;
    }

    public function asset($file)
    {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/';

        return $url . $file;
    }

    /**
     * @param string $toTranslate
     * @param array $toChanges
     * @return mixed|null
     */
    public function translate(string $toTranslate, array $toChanges = [])
    {
        return Translations::translate($toTranslate, $toChanges);
    }
}
