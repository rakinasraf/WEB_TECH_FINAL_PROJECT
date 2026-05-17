<?php
require_once 'models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function verifySession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                session_start();
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                $_SESSION['admin_role'] = $user['role'];
                header('Location: index.php?action=dashboard');
                exit();
            } else {
                $error = "Invalid Email/Password credentials or unauthorized access.";
                require_once 'views/login.php';
            }
        } else {
            require_once 'views/login.php';
        }
    }

    public function handleLogout() {
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}