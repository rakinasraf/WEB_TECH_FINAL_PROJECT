<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Coupon.php";

function clearCartCoupon() {
    unset($_SESSION['coupon'], $_SESSION['coupon_discount']);
}

function add($id) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=products");
        exit();
    }

    $id = (int)$id;
    if (!$id) {
        header("Location: index.php?action=products");
        exit();
    }

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }
    $_SESSION['cart'][$id]++;
    clearCartCoupon();

    $_SESSION['success'] = "Item added to cart!";
    $back = $_SERVER['HTTP_REFERER'] ?? "index.php?action=products";
    header("Location: $back");
    exit();
}

function cartView() {
    global $conn;

    $cart     = $_SESSION['cart'] ?? [];
    $products = [];
    $subtotal = 0;

    if (!empty($cart)) {
        $model    = new Product($conn);
        $rows     = $model->getByIds(array_keys($cart));
        foreach ($rows as $p) {
            $products[$p['id']] = $p;
        }
    }

    foreach ($cart as $pid => $qty) {
        if (isset($products[$pid])) {
            $subtotal += $products[$pid]['price'] * $qty;
        }
    }

    if (empty($cart) || $subtotal <= 0) {
        clearCartCoupon();
    }

    $couponModel = new Coupon($conn);
    $coupon      = $couponModel->getSessionCoupon($subtotal);
    $discount    = $coupon ? (float)$coupon['discount_amount'] : 0;
    $finalTotal  = max(0, $subtotal - $discount);

    include __DIR__ . "/../views/cart/cart.php";
}

function updateCart() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=cart");
        exit();
    }

    $quantities = $_POST['qty'] ?? [];
    foreach ($quantities as $id => $qty) {
        $id  = (int)$id;
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    clearCartCoupon();
    header("Location: index.php?action=cart");
    exit();
}

function removeItem($id) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=cart");
        exit();
    }

    $id = (int)$id;
    unset($_SESSION['cart'][$id]);
    clearCartCoupon();
    header("Location: index.php?action=cart");
    exit();
}
