<?php

namespace Blaj\BlajMVC\Core;

class FlashMessage
{
    public function __construct()
    {

    }

    /**
     * @param string
     * @param string
     */
    public function info(string $name, string $text)
    {
        $this->message($name, $text, 'info');
    }

    /**
     * @param string
     * @param string
     */
    public function success(string $name, string $text)
    {
        $this->message($name, $text, 'success');
    }

    /**
     * @param string
     * @param string
     */
    public function warning(string $name, string $text)
    {
        $this->message($name, $text, 'warning');
    }

    /**
     * @param string
     * @param string
     */
    public function error(string $name, string $text)
    {
        $this->message($name, $text, 'error');
    }

    /**
     * @param string
     * @param string
     * @param string
     */
    public function message($name, $text, $type)
    {
        $_SESSION['flashMessage'][$name]['text'] = $text;
        $_SESSION['flashMessage'][$name]['type'] = $type;
    }

    /**
     * @param string
     */
    public function display($name): string
    {
        $result = '';

        if (isset($_SESSION['flashMessage'][$name]))
            $result = $_SESSION['flashMessage'][$name]['text'];

        $this->clear($name);

        return $result;
    }

    /**
     * @param string
     */
    public function clear($name)
    {
        unset($_SESSION['flashMessage'][$name]);
    }
}
