<?php

namespace Blaj\BlajMVC\Core;

use \PDO;
use PDOException;

class Model {

    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }
    }
}
