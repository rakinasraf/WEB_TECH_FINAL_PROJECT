<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/Coupon.php";

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';

if ($type === 'validate_coupon') {

    $code     = trim($_POST['code'] ?? '');
    $subtotal = (float)($_POST['subtotal'] ?? 0);

    $couponModel = new Coupon($conn);

    if ($code === '') {
        $couponModel->clearSession();
        echo json_encode(['status' => 'error', 'message' => 'Enter a coupon code.']);
        exit();
    }

    if ($subtotal <= 0) {
        $couponModel->clearSession();
        echo json_encode(['status' => 'error', 'message' => 'Cart total is not valid.']);
        exit();
    }

    $coupon = $couponModel->getValidByCode($code);

    if (!$coupon) {
        $couponModel->clearSession();
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired coupon.']);
        exit();
    }

    if ($subtotal < (float)$coupon['min_order_amount']) {
        $couponModel->clearSession();
        echo json_encode([
            'status'  => 'error',
            'message' => 'Minimum order amount is ৳' . number_format($coupon['min_order_amount'], 2) . '.'
        ]);
        exit();
    }

    $sessionCoupon = $couponModel->saveToSession($coupon, $subtotal);

    echo json_encode([
        'status'       => 'ok',
        'coupon_id'    => $sessionCoupon['coupon_id'],
        'coupon_code'  => $sessionCoupon['coupon_code'],
        'discount_pct' => $sessionCoupon['discount_pct'],
        'discount_amt' => $sessionCoupon['discount_amount'],
        'new_total'    => $sessionCoupon['final_total'],
        'message'      => $sessionCoupon['discount_pct'] . '% discount applied!'
    ]);

} elseif ($type === 'order_status') {

    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'Not logged in.']);
        exit();
    }

    $order_id = (int)($_GET['order_id'] ?? 0);
    $user_id  = (int)$_SESSION['user']['id'];

    $sql = "SELECT o.status, d.status AS delivery_status
            FROM orders o
            LEFT JOIN delivery_assignments d ON d.order_id = o.id
            WHERE o.id = $order_id AND o.customer_id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
        exit();
    }

    echo json_encode([
        'status'          => 'ok',
        'order_status'    => $row['status'],
        'delivery_status' => $row['delivery_status'] ?? 'not assigned'
    ]);

} elseif ($type === 'wishlist_toggle') {

    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login first.']);
        exit();
    }

    require_once __DIR__ . "/../models/Wishlist.php";

    $uid = (int)$_SESSION['user']['id'];
    $pid = (int)($_POST['product_id'] ?? 0);
    $wishlistAction = $_POST['action'] ?? 'toggle';

    if (!$pid) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product.']);
        exit();
    }

    $wl = new Wishlist($conn);

    if ($wishlistAction === 'add') {
        if (!$wl->exists($uid, $pid)) {
            $wl->add($uid, $pid);
        }
        echo json_encode(['status' => 'ok', 'in_wishlist' => true, 'message' => 'Added to wishlist!']);
    } elseif ($wishlistAction === 'remove') {
        $wl->remove($uid, $pid);
        echo json_encode(['status' => 'ok', 'in_wishlist' => false, 'message' => 'Removed from wishlist.']);
    } else {
        if ($wl->exists($uid, $pid)) {
            $wl->remove($uid, $pid);
            echo json_encode(['status' => 'ok', 'in_wishlist' => false, 'message' => 'Removed from wishlist.']);
        } else {
            $wl->add($uid, $pid);
            echo json_encode(['status' => 'ok', 'in_wishlist' => true, 'message' => 'Added to wishlist!']);
        }
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Unknown request.']);
}
