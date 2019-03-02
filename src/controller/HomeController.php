<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Model\ArticleModel;
use Blaj\BlajMVC\Repository\ArticleRepository;
use Blaj\BlajMVC\Core\FormValidation\FormValidator;
use Blaj\BlajMVC\Core\Utils\Translations;

class HomeController extends Controller {

    private $view;
    private $articleModel;
    private $articleRepository;

    public function __construct()
    {
        $this->view = new View('layout/layout.phtml');
        $this->articleModel = new ArticleModel();
        $this->articleRepository = new ArticleRepository();
    }

    public function index()
    {
        $app_title = Translations::Translate('app_title');

        //$this->articleRepository->save();

        $this->view->body = new View('index.phtml');
        $this->view->body->app_title = $app_title;

        return $this->view;
    }

    public function read()
    {
        $this->view->body = new View('read.phtml');
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
                    'rules' => 'unique:article'
                ),
                array(
                    'value' => $_POST['content'],
                    'name' => 'content',
                    'displayname' => 'Treść',
                    'rules' => 'required'
                )
            );

            $validator = new FormValidator($validator_config);

            //$validator->addRule($_POST['title'], 'title', 'Tytuł', 'required|min_length:3|max_length:10');
            //$validator->addRule($_POST['content'], 'content', 'Treść', 'min_length:3');

            if ($validator->run()) {

            } else {
                //echo $validator->showErrors();
                $this->view->body->errors = $validator->showErrors();
            }
        }

        return $this->view;
    }
}
