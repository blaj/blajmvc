<?php

namespace Blaj\BlajMVC\Repository;

use Blaj\BlajMVC\Core\Repository;

class ArticleRepository extends Repository
{
    protected $tableName = 'article';

    private $id;

    private $title;

    private $content;
}
