
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new User($db);
    }

    public function showLogin() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function showRegister() {
        require_once __DIR__ . '/../views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->login($correo, $password);
            
            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['nombre'] = $user['NOMBRE'];
                $_SESSION['rol'] = $user['ROL'];
                header('Location: index.php?page=admin_panel');
                exit();
            } else {
                header('Location: index.php?page=login&error=1');
                exit();
            }
        }
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($this->userModel->registrar($nombre, $correo, $password)) {
                header('Location: index.php?page=login&msg=success');
            } else {
                header('Location: index.php?page=register&error=1');
            }
            exit();
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }
}