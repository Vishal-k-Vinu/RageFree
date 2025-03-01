<?php
require_once 'models/User.php';
require_once 'utils/Validator.php';

class AuthController {
    private $userModel;
    private const SIGNUP_VIEW = 'views/auth/signup.php';
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
            $validator = new Validator($_POST);
            
            // Validate all fields
            $validator->required('fname', 'First name is required')
                     ->required('lname', 'Last name is required')
                     ->required('uname', 'Username is required')
                     ->minLength('uname', 5, 'Username must be at least 5 characters')
                     ->pattern('uname', '/^[a-zA-Z0-9_]+$/', 'Username can only contain letters, numbers, and underscores')
                     ->required('email', 'Email is required')
                     ->email('email', 'Please enter a valid email address')
                     ->required('pass', 'Password is required')
                     ->minLength('pass', 8, 'Password must be at least 8 characters')
                     ->pattern('pass', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/','Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character')
                     ->required('roles', 'Role is required');

            if ($validator->hasErrors()) {
                ob_start();
                include self::SIGNUP_VIEW;
                $content = ob_get_clean();
                include_once 'views/layouts/main.php';
                return;
            }

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
                include self::SIGNUP_VIEW;
                $content = ob_get_clean();
                include 'views/layouts/main.php';
            }
        } else {
            ob_start();
            include self::SIGNUP_VIEW;
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