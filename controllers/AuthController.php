<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['uname'] ?? '';
            $password = $_POST['pass'] ?? '';
            $role = $_POST['roles'] ?? '';

            $user = $this->userModel->authenticate($username, $password, $role);
            
            if ($user) {
                $_SESSION['user'] = $user;
                
                if ($user['roles'] === 'admin') {
                    header('Location: /phplogin/admin/dashboard');
                } else {
                    header('Location: /phplogin/student/registration');
                }
                exit();
            } else {
                $error = "Invalid credentials";
                ob_start();
                include 'views/auth/login.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
            }
        } else {
            ob_start();
            include 'views/auth/login.php';
            $content = ob_get_clean();
            include 'views/layouts/main.php';
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'firstname' => $_POST['fname'],
                'lastname' => $_POST['lname'],
                'username' => $_POST['uname'],
                'email' => $_POST['email'],
                'password' => $_POST['pass'],
                'role' => $_POST['roles']
            ];

            if ($this->userModel->register($userData)) {
                $_SESSION['signup_success'] = true;
                header('Location: /phplogin/login');
                exit();
            } else {
                $error = "Registration failed";
                ob_start();
                include 'views/auth/signup.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
            }
        } else {
            ob_start();
            include 'views/auth/signup.php';
            $content = ob_get_clean();
            include 'views/layouts/main.php';
        }
    }

    public function handleSignup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'firstname' => $_POST['fname'],
                'lastname' => $_POST['lname'],
                'username' => $_POST['uname'],
                'email' => $_POST['email'],
                'password' => $_POST['pass'],
                'role' => $_POST['roles']
            ];

            if ($this->userModel->register($userData)) {
                $_SESSION['signup_success'] = true;
                header('Location: /phplogin/login');
                exit();
            } else {
                $error = "Registration failed";
                header('Location: /phplogin/signup');
                exit();
            }
        } else {
            header('Location: /phplogin/signup');
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /phplogin/login');
        exit();
    }
} 