<?php

namespace Blaj\BlajMVC\Core;

class FlashMessage
{
    public function __construct()
    {

    }

    public function info($name, $text)
    {
        $this->message($name, $text, 'info');
    }

    public function success($name, $text)
    {
        $this->message($name, $text, 'success');
    }

    public function warning($name, $text)
    {
        $this->message($name, $text, 'warning');
    }

    public function error($name, $text)
    {
        $this->message($name, $text, 'error');
    }

    public function message($name, $text, $type)
    {
        $_SESSION['flashMessage'][$name]['text'] = $text;
        $_SESSION['flashMessage'][$name]['type'] = $type;
    }

    public function display($name)
    {
        $result = '';

        if (isset($_SESSION['flashMessage'][$name]))
            $result = $_SESSION['flashMessage'][$name]['text'];

        $this->clear($name);

        return $result;
    }

    public function clear($name)
    {
        unset($_SESSION['flashMessage'][$name]);
    }
}
