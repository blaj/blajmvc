<?php

namespace Blaj\BlajMVC\Core;

use PDO;

class DB
{
    private static $db;

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public function __serialize()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$db)) {
            try {
                self::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("PDO Error:" . $e->getMessage());
            }
        }

        return self::$db;
    }
}
