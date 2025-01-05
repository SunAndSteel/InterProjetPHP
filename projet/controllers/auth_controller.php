<?php
require_once 'models/login_model.php';
require_once '../session.php';

class auth_controller
{
    private $login_model;

    public function __construct($config)
    {
        $this->login_model = new login_model($config);
        session::start();
    }

    public function login()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
if (empty($username) || empty($password)) {
            $error = "Veuillez remplir tous les champs";
            include 'views/error.php';
            exit;
        }

        if ($this->login_model->ldapLogin($username, $password)) {
            session::set('user', $username);
            header('Location: index.php?action=dashboard');
            exit;
        } else {
            $error = "Mot de passe ou Compte incorrect";
            include 'views/error.php';
            exit;
        }
    }

    public function logout()
    {
        session::destroy();
        ldap_unbind($this->login_model);
        header('Location: index.php?action=login');
        exit;
    }


    public function dashboard()
    {
        $user = session::get('user');
        if (!$user) {
            header('Location: index.php');
            exit;
        }
        include 'views/user_controller.php';
    }
}
