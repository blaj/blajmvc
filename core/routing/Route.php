<?php

namespace Blaj\BlajMVC\Core\Routing;

class Route
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $controllerFile;

    /**
     * @var string
     */
    protected $controllerClass;

    /**
     * @var string
     */
    protected $controllerAction;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $defaults;

    /**
     * Route construct
     *
     * @param string
     * @param string
     * @param array
     * @param array
     */
    public function __construct(string $path, string $config, array $params = [], array $defaults = [])
    {
        $this->path = HTTP_SERVER . $path;

        $config = explode('@', $config);

        $this->controllerFile = DIR_CONTROLLER . $config[0] . '.php';
        $this->controllerClass = '\Blaj\BlajMVC\Controller\\' . $config[0];
        $this->controllerAction = $config[1];
        $this->params = $params;
        $this->defaults = $defaults;
    }

    /**
     * Function to generate URL
     *
     * @param array|string
     * @return string
     */
    public function generateUrl($data): string
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

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getControllerFile(): string
    {
        return $this->controllerFile;
    }

    /**
     * @param string
     */
    public function setControllerFiler(string $controllerFile)
    {
        $this->controllerFile = $controllerFile;
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @param string
     */
    public function setControllerClass(string $controllerClass)
    {
        $this->controllerClass = $controllerClass;
    }

    /**
     * @return string
     */
    public function getControllerAction(): string
    {
        return $this->controllerAction;
    }

    /**
     * @param string
     */
    public function setControllerAction(string $controllerAction)
    {
        $this->controllerAction = $controllerAction;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * @param array
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }
}
