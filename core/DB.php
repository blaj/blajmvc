<?php

namespace Blaj\BlajMVC\Core;

class DB
{
    static protected $db;

    public function __construct()
    {
        if (!self::$db) {
            try {
                self::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            } catch (PDOException $e) {
                die("PDO Error:" . $e->getMessage());
            }
        }
    }

    public function getInstance()
    {
        if (!self::$db)
            self::$db = new self();

        return self::$db;
    }

    public function __clone()
    {
    }
}
