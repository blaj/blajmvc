<?php

namespace Blaj\BlajMVC\Core;

class FlashMessage
{
    public static function info($name, $text)
    {
        self::message($name, $text, 'info');
    }

    public static function success($name, $text)
    {
        self::message($name, $text, 'success');
    }

    public static function warning($name, $text)
    {
        self::message($name, $text, 'warning');
    }

    public static function error($name, $text)
    {
        self::message($name, $text, 'error');
    }

    public static function message($name, $text, $type)
    {
        $_SESSION['flashMessage'][$name]['text'] = $text;
        $_SESSION['flashMessage'][$name]['type'] = $type;
    }

    public static function display($name)
    {
        $result = '';

        if (isset($_SESSION['flashMessage'][$name]))
            $result = $_SESSION['flashMessage'][$name]['text'];

        self::clear($name);

        return $result;
    }

    public static function clear($name)
    {
        unset($_SESSION['flashMessage'][$name]);
    }
}
