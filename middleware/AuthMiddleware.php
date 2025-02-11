<?php
require_once 'BaseMiddleware.php';

class AuthMiddleware extends BaseMiddleware {
    public static function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    public static function isAdmin() {
        return self::isAuthenticated() && $_SESSION['user']['roles'] === 'admin';
    }

    public static function isStudent() {
        return self::isAuthenticated() && $_SESSION['user']['roles'] === 'users';
    }

    public function requireAuth() {
        if (!self::isAuthenticated()) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['error' => 'Unauthorized'], 401);
            }
            $this->redirect('/phplogin/login');
        }
    }

    public function requireAdmin() {
        if (!self::isAdmin()) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['error' => 'Unauthorized'], 403);
            }
            $this->redirect('/phplogin/login');
        }
    }

    public function requireStudent() {
        if (!self::isStudent()) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['error' => 'Unauthorized'], 403);
            }
            $this->redirect('/phplogin/login');
        }
    }

    public function handleGuestOnly() {
        if (self::isAuthenticated()) {
            $role = $_SESSION['user']['roles'];
            $redirect = $role === 'admin' ? '/phplogin/admin/dashboard' : '/phplogin/student/registration';
            $this->redirect($redirect);
        }
    }
} 