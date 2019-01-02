<?php

namespace Blaj\BlajMVC\Model;

use Blaj\BlajMVC\Core\Model;

class ArticleModel extends Model
{

    public function getAll()
    {
        $query = $this->db->query("SELECT * FROM article");
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($items))
            return $items;
        else
            return null;
    }

    public function getOne($id)
    {
        $query = $this->db->prepare("SELECT * FROM article WHERE id = :id");
        $query->execute(['id' => $id]);
        $items = $query->fetchAll(\PDO::FETCH_ASSOC);
        if (isset($items[0])) {
            return $items[0];
        } else {
            return null;
        }
    }
}
