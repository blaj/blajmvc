<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Model\ArticleModel;
use Blaj\BlajMVC\Core\FormValidation\FormValidator;

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

    public function add()
    {
        if (!empty($_POST)) {
            $validator = new FormValidator();

            $validator->addRule('title', 'Tytuł', 'required|min_length:3|max_length:10');
            $validator->addRule('content', 'Treść', 'min_length:3');

            if ($validator->run()) {

            }
        }

        $this->view->body = new View('add.phtml');
        return $this->view;
    }
}
