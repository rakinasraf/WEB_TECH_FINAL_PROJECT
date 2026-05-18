<?php

require_once "models/db.php";
require_once "controllers/AuthMiddleware.php";

$action = $_GET['action'] ?? 'home';

switch ($action) {

    // ── PUBLIC ────────────────────────────────────────────────────────
    case 'home':
        include "views/auth/home.php";
        break;

    case 'login':
        include "views/auth/login.php";
        break;

    case 'register':
        include "views/auth/register.php";
        break;

    case 'do_login':
        require_once "controllers/AuthController.php";
        login();
        break;

    case 'do_register':
        require_once "controllers/AuthController.php";
        register();
        break;

    case 'logout':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit();
        }
        require_once "controllers/AuthController.php";
        logout();
        break;

    // ── PRODUCTS (public) ─────────────────────────────────────────────
    case 'products':
        require_once "controllers/ProductController.php";
        index();
        break;

    case 'product_details':
        require_once "controllers/ProductController.php";
        details($_GET['id'] ?? 0);
        break;

    // ── CUSTOMER (protected) ──────────────────────────────────────────
    case 'dashboard':
        checkAuth();
        include "views/customer/dashboard.php";
        break;

    case 'profile':
        checkAuth();
        include "views/customer/profile.php";
        break;

    case 'update_profile':
        checkAuth();
        require_once "controllers/AuthController.php";
        updateProfile();
        break;

    case 'change_password':
        checkAuth();
        require_once "controllers/AuthController.php";
        changePassword();
        break;

    case 'upload_profile_picture':
        checkAuth();
        require_once "controllers/AuthController.php";
        uploadProfilePicture();
        break;

    case 'addresses':
        checkAuth();
        require_once "controllers/AddressController.php";
        addressList();
        break;

    case 'save_address':
        checkAuth();
        require_once "controllers/AddressController.php";
        saveAddress();
        break;

    case 'delete_address':
        checkAuth();
        require_once "controllers/AddressController.php";
        deleteAddress();
        break;

    // ── CART ──────────────────────────────────────────────────────────
    case 'cart':
        require_once "controllers/CartController.php";
        cartView();
        break;

    case 'add_cart':
        checkAuth();
        require_once "controllers/CartController.php";
        add($_POST['product_id'] ?? 0);
        break;

    case 'update_cart':
        require_once "controllers/CartController.php";
        updateCart();
        break;

    case 'remove_cart':
        require_once "controllers/CartController.php";
        removeItem($_POST['product_id'] ?? 0);
        break;

    // ── ORDERS ────────────────────────────────────────────────────────
    case 'checkout':
        checkAuth();
        require_once "controllers/OrderController.php";
        checkoutView();
        break;

    case 'place_order':
        checkAuth();
        require_once "controllers/OrderController.php";
        placeOrder();
        break;

    case 'order_confirmation':
        checkAuth();
        require_once "controllers/OrderController.php";
        orderConfirmation($_GET['id'] ?? 0);
        break;

    case 'order_history':
        checkAuth();
        require_once "controllers/OrderController.php";
        orderHistory();
        break;

    case 'order_detail':
        checkAuth();
        require_once "controllers/OrderController.php";
        orderDetail($_GET['id'] ?? 0);
        break;

    case 'cancel_order':
        checkAuth();
        require_once "controllers/OrderController.php";
        cancelOrder($_GET['id'] ?? 0);
        break;

    case 'submit_return_request':
        checkAuth();
        require_once "controllers/OrderController.php";
        submitReturnRequest();
        break;

    case 'disputes':
        checkAuth();
        require_once "controllers/OrderController.php";
        disputeList();
        break;

    case 'open_dispute':
        checkAuth();
        require_once "controllers/OrderController.php";
        openDispute();
        break;

    // ── REVIEWS ───────────────────────────────────────────────────────
    case 'submit_review':
        checkAuth();
        require_once "controllers/ReviewController.php";
        submitReview();
        break;

    case 'edit_review':
        checkAuth();
        require_once "controllers/ReviewController.php";
        editReview();
        break;

    case 'delete_review':
        checkAuth();
        require_once "controllers/ReviewController.php";
        deleteReview();
        break;

    // ── WISHLIST ──────────────────────────────────────────────────────
    case 'wishlist':
        checkAuth();
        require_once "models/Wishlist.php";
        $wlModel  = new Wishlist($conn);
        $wishlist = $wlModel->getByUser($_SESSION['user']['id']);
        include "views/customer/wishlist.php";
        break;

    // ── AJAX ──────────────────────────────────────────────────────────
    case 'ajax':
        require_once "controllers/AjaxController.php";
        break;

    default:
        echo "<h2 style='font-family:Arial;text-align:center;margin-top:80px;'>404 — Page Not Found</h2>";
        echo "<p style='text-align:center;'><a href='index.php'>Go Home</a></p>";
}
