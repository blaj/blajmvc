<?php

namespace Blaj\BlajMVC\Controller;

use Blaj\BlajMVC\Core\Controller;
use Blaj\BlajMVC\Core\FormValidation\FormValidator;
use Blaj\BlajMVC\Core\Utils\Session;
use Blaj\BlajMVC\Core\View;
use Blaj\BlajMVC\Repository\ExampleUserRepository;

class ExampleUserController extends Controller {

    private $view;

    private $exampleUserRepository;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View('layout/layout.phtml');

        $this->exampleUserRepository = new ExampleUserRepository();

        $this->addRole('User', 'Guest');
        $this->addPrivilenge(true);

        // Privilenges for Guest
        $this->addPrivilenge(true, 'Guest', 'index');
        $this->addPrivilenge(true, 'Guest', 'login');
        $this->addPrivilenge(false, 'Guest', 'logout');

        // Privielenges for logged User
        $this->addPrivilenge(true, 'User');
        $this->addPrivilenge(false, 'User', 'login');

        $role = Session::get('role') ? Session::get('role') : 'Guest';
        $this->setRole($role);
    }

    protected function login()
    {
        if ($_POST) {
            $validator_config = array(
                array(
                    'value' => $_POST['username'],         // Value to validate
                    'name' => 'username',                  // Name
                    'displayname' => 'Title',           // Display name
                    'rules' => 'required'      // Rules list
                ),
                array(
                    'value' => $_POST['password'],
                    'name' => 'password',
                    'displayname' => 'Content',
                    'rules' => 'required'
                )
            );

            $validator = new FormValidator($validator_config);

            if ($validator->run()) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);

                $user = $this->exampleUserRepository->findOneBy(['username' => $username, 'password' => $password]);
                if (!empty($user)) {
                    Session::set('role', 'User');
                    $this->redirect('example_home/index');
                }
            }
        }

        $this->view->body = new View('example_user/login.phtml');
        return $this->view;
    }

    protected function logout()
    {
        Session::unset('role');
        $this->redirect('example_home/index');
    }
}