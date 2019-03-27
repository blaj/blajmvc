<?php

namespace Blaj\BlajMVC\Repository;

use Blaj\BlajMVC\Core\Repository;

class ExampleUserRepository extends Repository
{
    protected $tableName = 'example_user';

    private $id;

    private $name;

    private $password;

    private $email;
}
