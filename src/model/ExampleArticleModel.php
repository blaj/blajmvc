<?php

namespace Blaj\BlajMVC\Model;

use Blaj\BlajMVC\Core\Model;
use Blaj\BlajMVC\Core\IModel;

class ExampleArticleModel extends Model implements IModel
{
    private $id;

    private $title;

    private $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
