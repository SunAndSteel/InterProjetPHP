<?php include 'templates/navbar.php'; ?>

<?php
require '../controllers/user_controller.php';
require '../controllers/auth_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $userController->createController($username);
}


$config = require 'config.php';
$auth_controller = new auth_controller($config);

$action = $_GET['action'] ?? 'login';
switch ($action) {
    case 'login':
        $auth_controller->login();
        break;
    case 'logout':
        $auth_controller->logout();
        break;
    case 'dashboard':
        $auth_controller->dashboard();
        break;
    default:
        $auth_controller->login();
}

