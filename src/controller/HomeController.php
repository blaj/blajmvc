<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Model\ArticleModel;
use Blaj\BlajMVC\Repository\ArticleRepository;
use Blaj\BlajMVC\Core\FormValidation\FormValidator;
use Blaj\BlajMVC\Core\Utils\Translations;
use Blaj\BlajMVC\Core\FlashMessage;

class HomeController extends Controller {

    private $view;
    private $articleRepository;

    public function __construct()
    {
        $this->view = new View('layout/layout.phtml');
        $this->articleRepository = new ArticleRepository();
    }

    public function index()
    {
        $app_title = Translations::Translate('app_title');

        $articles = $this->articleRepository->findAll();
        FlashMessage::success('register_success', 'Rejestracja zakonczona');

        $this->view->body = new View('index.phtml');
        $this->view->body->app_title = $app_title;
        $this->view->body->articles = $articles;

        return $this->view;
    }

    public function read()
    {
        $article = $this->articleRepository->findOneById($_GET['id']);


        echo FlashMessage::display('register_success');

        $this->view->body = new View('read.phtml');
        $this->view->body->article = $article;
        return $this->view;
    }

    public function add()
    {
        $this->view->body = new View('add.phtml');

        if (!empty($_POST)) {
            $validator_config = array(
                array(
                    'value' => $_POST['title'],
                    'name' => 'title',
                    'displayname' => 'Tytuł',
                    'rules' => 'required'
                ),
                array(
                    'value' => $_POST['content'],
                    'name' => 'content',
                    'displayname' => 'Treść',
                    'rules' => 'required'
                )
            );

            $validator = new FormValidator($validator_config);

            if ($validator->run()) {
                $article = new ArticleModel();
                $article->setTitle($_POST['title']);
                $article->setContent($_POST['content']);

                $this->articleRepository->add($article);
            } else {
                //echo $validator->showErrors();
                $this->view->body->errors = $validator->showErrors();
            }
        }

        return $this->view;
    }
}
