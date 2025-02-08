<?php
require_once 'BaseMiddleware.php';

class AuthMiddleware extends BaseMiddleware {
    public static function isAuthenticated() {
        session_start();
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
            $this->redirect('/login');
        }
    }

    public function requireAdmin() {
        if (!self::isAdmin()) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['error' => 'Unauthorized'], 403);
            }
            $this->redirect('/login');
        }
    }

    public function requireStudent() {
        if (!self::isStudent()) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(['error' => 'Unauthorized'], 403);
            }
            $this->redirect('/login');
        }
    }

    public function handleGuestOnly() {
        if (self::isAuthenticated()) {
            $role = $_SESSION['user']['roles'];
            $redirect = $role === 'admin' ? '/admin/dashboard' : '/student/registration';
            $this->redirect($redirect);
        }
    }
} 