
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/config/database.php';
require_once 'app/controllers/UserController.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? '';

$userCtrl = new UserController();

switch ($page) {
    case 'login':
        if ($action === 'login') {
            $userCtrl->login();
        } else {
            $userCtrl->showLogin();
        }
        break;

    case 'register':
        if ($action === 'registro') {
            $userCtrl->registro();
        } else {
            $userCtrl->showRegister();
        }
        break;

    case 'logout':
        $userCtrl->logout();
        break;

    default:
        $userCtrl->showLogin();
        break;
}