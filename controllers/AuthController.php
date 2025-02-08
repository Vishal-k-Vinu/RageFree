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
                session_start();
                $_SESSION['user'] = $user;
                
                if ($user['roles'] === 'admin') {
                    header('Location: admin/dashboard');
                } else {
                    header('Location: student/registration');
                }
                exit();
            } else {
                $error = "Invalid credentials";
                include 'views/auth/login.php';
            }
        } else {
            include 'views/auth/login.php';
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
                header('Location: login');
                exit();
            } else {
                $error = "Registration failed";
                include 'views/auth/signup.php';
            }
        } else {
            include 'views/auth/signup.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
} 