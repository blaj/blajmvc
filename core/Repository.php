<?php

namespace Blaj\BlajMVC\Core;

use Blaj\BlajMVC\Core\DB;

class Repository extends DB
{
    protected $tableName;

    public function __construct()
    {
        $class = new \ReflectionClass($this);

        if (empty($this->tableName))
            $this->tableName = substr(strtolower($class->getShortName()), 0, -10);

        $query = DB::getInstance()->query("SELECT * FROM article");
        $items = DB::getInstance()->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($items))
            print_r($items);
    }

}
