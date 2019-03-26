<?php

namespace Blaj\BlajMVC\Repository;

use Blaj\BlajMVC\Core\Repository;

class ExampleArticleRepository extends Repository
{
    protected $tableName = 'example_article';

    private $id;

    private $title;

    private $content;
}
