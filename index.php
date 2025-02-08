<?php
// Entry point
define('BASE_PATH', __DIR__);
require_once 'middleware/AuthMiddleware.php';

$auth = new AuthMiddleware();

// Simple router
$route = $_GET['route'] ?? 'login';

// Protected routes
$adminRoutes = ['admin/dashboard', 'complaint/view'];
$studentRoutes = ['student/registration', 'complaint/create'];
$guestRoutes = ['login', 'signup'];

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
    'logout' => ['AuthController', 'logout'],
    'admin/dashboard' => ['AdminController', 'dashboard'],
    'student/registration' => ['StudentController', 'registration'],
    'complaint/create' => ['ComplaintController', 'create'],
    'complaint/view' => ['ComplaintController', 'view'],
    'complaint/success' => ['ComplaintController', 'showSuccess'],
];

if (isset($routes[$route])) {
    [$controller, $method] = $routes[$route];
    require_once "controllers/{$controller}.php";
    $controller = new $controller();
    $controller->$method();
} else {
    // 404 handling
    header("HTTP/1.0 404 Not Found");
    include 'views/errors/404.php';
}
