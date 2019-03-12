<?php

namespace Blaj\BlajMVC\Core\Utils;

class Session
{
    private static $prefix = "_bmvc";

    private static $sessionStarted = false;

    private function __construct()
    {

    }

    public static function start($lifeTime = 0)
    {
        if (!self::$sessionStarted) {
            session_set_cookie_params($lifeTime);
            session_start();

            self::$sessionStarted = true;
        }
    }

    public static function set($name, $data = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $_SESSION[self::$prefix][$key] = $value;
            }
        } else {
            $_SESSION[self::$prefix][$name] = $data;
        }
    }

    public static function unset($name)
    {
        unset($_SESSION[self::$prefix][$name]);
    }

    public static function get($name)
    {
        if (isset($_SESSION[self::$prefix][$name]))
            return $_SESSION[self::$prefix][$name];

        return null;
    }

    public static function pull($name)
    {
        $result = self::get($name);
        self::unset($name);

        return $result;
    }

    public static function getId()
    {
        return session_id();
    }

    public static function regenerate()
    {
        session_regenerate_id(true);
    }

    /**
     * @param string
     */
    public static function setPrefix(string $prefix)
    {
        self::$prefix = $prefix;
    }

    /**
     * @return string
     */
    public static function getPrefix(): string
    {
        return self::$prefix;
    }
}
