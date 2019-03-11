<?php

namespace Blaj\BlajMVC\Model;

use Blaj\BlajMVC\Core\Model;
use Blaj\BlajMVC\Core\IModel;

class ArticleModel extends Model implements IModel
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

    // public function getAll()
    // {
    //     $query = $this->db->query("SELECT * FROM article");
    //     $items = $query->fetchAll(\PDO::FETCH_ASSOC);
    //     if (isset($items))
    //         return $items;
    //     else
    //         return null;
    // }
    //
    // public function getOne($id)
    // {
    //     $query = $this->db->prepare("SELECT * FROM article WHERE id = :id");
    //     $query->execute(['id' => $id]);
    //     $items = $query->fetchAll(\PDO::FETCH_ASSOC);
    //     if (isset($items[0])) {
    //         return $items[0];
    //     } else {
    //         return null;
    //     }
    // }
}
