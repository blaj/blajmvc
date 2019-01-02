<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Model\ArticleModel;

class HomeController extends Controller {

    private $view;
    private $articleModel;

    public function __construct()
    {
        $this->view = new View('layout/layout.phtml');
        $this->articleModel = new ArticleModel();
    }

    public function index()
    {
        $articles = $this->articleModel->getAll();

        $this->view->body = new View('index.phtml');
        $this->view->body->articles = $articles;
        return $this->view;
    }

    public function read()
    {
        $article = $this->articleModel->getOne($_GET['id']);

        $this->view->body = new View('read.phtml');
        $this->view->body->article = $article;
        return $this->view;
    }
}
