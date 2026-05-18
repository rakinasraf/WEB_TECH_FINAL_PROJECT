<?php
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/AdminController.php';

$database = new Database();
$db = $database->getConnection();

$authController = new AuthController($db);
$adminController = new AdminController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    case 'login':
        $authController->handleLogin();
        break;
    case 'logout':
        $authController->handleLogout();
        break;
    case 'dashboard':
        $authController->verifySession();
        $adminController->showDashboard();
        break;
    case 'approve_seller_ajax':
        $authController->verifySession();
        $adminController->approveSellerAjax();
        break;
        
 
    case 'sellers':
        $authController->verifySession();
        $adminController->showSellers();
        break;
    case 'categories':
        $authController->verifySession();
        $adminController->showCategories();
        break;
    case 'products':
        $authController->verifySession();
        $adminController->showProducts();
        break;
    case 'orders':
        $authController->verifySession();
        $adminController->showOrders();
        break;
    case 'coupons':
        $authController->verifySession();
        $adminController->showCoupons();
        break;
    case 'disputes':
        $authController->verifySession();
        $adminController->showDisputes();
        break;
    case 'analytics':
        $authController->verifySession();
        $adminController->showAnalytics();
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Module interface view panel route does not exist.";
        break;
}