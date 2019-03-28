<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\Utils\Session;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Repository\ExampleArticleRepository;

class ExampleHomeController extends Controller {

    private $view;

    private $exampleArticleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View('layout/layout.phtml');

        $this->exampleArticleRepository = new ExampleArticleRepository();

        $role = Session::get('role') ? Session::get('role') : 'Guest';
        $this->setRole($role);
    }

    public function index()
    {
        $articles = $this->exampleArticleRepository->findAll();

        $this->view->body = new View('example_home/index.phtml');
        $this->view->body->articles = $articles;
        return $this->view;
    }

    public function show()
    {
        $article = $this->exampleArticleRepository->findOneById($_GET['id']);

        $this->view->body = new View('example_home/show.phtml');
        $this->view->body->article = $article;
        return $this->view;
    }
}
