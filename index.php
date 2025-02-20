<?php
// Entry point
define('BASE_PATH', dirname(__FILE__));

// Error reporting based on environment
if (getenv('ENVIRONMENT') === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require_once 'middleware/AuthMiddleware.php';

// Start session securely
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
session_start();

$auth = new AuthMiddleware();

// Get the route from URL and clean it
$route = trim($_GET['route'] ?? '', '/');
$route = $route ?: 'login'; // Default to login if no route

// Debug routing - remove in production
if (getenv('ENVIRONMENT') !== 'production') {
    error_log("Requested Route: " . $route);
}

// Protected routes
$adminRoutes = ['admin/dashboard', 'complaint/view'];
$studentRoutes = ['student/registration', 'complaint/create'];
$guestRoutes = ['login', 'signup'];

try {
    // Check routes access
    if (in_array($route, $adminRoutes)) {
        $auth->requireAdmin();
    } elseif (in_array($route, $studentRoutes)) {
        $auth->requireStudent();
    } elseif (in_array($route, $guestRoutes)) {
        $auth->handleGuestOnly();
    }

    // Map routes to controllers
    $routes = [
        'login' => ['AuthController', 'login'],
        'signup' => ['AuthController', 'signup'],
        'signup-submit' => ['AuthController', 'handleSignup'],
        'logout' => ['AuthController', 'logout'],
        'admin/dashboard' => ['AdminController', 'dashboard'],
        'student/registration' => ['StudentController', 'registration'],
        'complaint/create' => ['ComplaintController', 'create'],
        'complaint/view' => ['ComplaintController', 'view'],
        'complaint/success' => ['ComplaintController', 'showSuccess'],
    ];

    if (isset($routes[$route])) {
        [$controller, $method] = $routes[$route];
        $controllerFile = "controllers/{$controller}.php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controller();
            $controller->$method();
        } else {
            throw new Exception("Controller file not found: {$controllerFile}");
        }
    } else {
        throw new Exception("Route not found: {$route}", 404);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    if ($e->getCode() === 404) {
        header("HTTP/1.0 404 Not Found");
        include 'views/errors/404.php';
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        include 'views/errors/500.php';
    }
}
