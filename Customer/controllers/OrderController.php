<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Coupon.php";
require_once __DIR__ . "/../models/ShippingAddress.php";
require_once __DIR__ . "/../models/DeliveryZone.php";
require_once __DIR__ . "/../models/ReturnRequest.php";
require_once __DIR__ . "/../models/Dispute.php";

function checkoutView() {
    global $conn;

    $cart = $_SESSION['cart'] ?? [];
    if (empty($cart)) {
        header("Location: index.php?action=cart");
        exit();
    }

    $model    = new Product($conn);
    $rows     = $model->getByIds(array_keys($cart));
    $products = [];
    foreach ($rows as $p) {
        $products[$p['id']] = $p;
    }

    $subtotal = 0;
    foreach ($cart as $pid => $qty) {
        if (isset($products[$pid])) {
            $subtotal += $products[$pid]['price'] * $qty;
        }
    }

    $couponModel = new Coupon($conn);
    $coupon      = $couponModel->getSessionCoupon($subtotal);
    $discount    = $coupon ? (float)$coupon['discount_amount'] : 0;
    $discountedTotal = max(0, $subtotal - $discount);

    $addressModel = new ShippingAddress($conn);
    $zoneModel    = new DeliveryZone($conn);
    $addresses    = $addressModel->getByUser($_SESSION['user']['id']);
    $zones        = $zoneModel->getAll();

    include __DIR__ . "/../views/orders/checkout.php";
}

function placeOrder() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=checkout");
        exit();
    }

    $cart = $_SESSION['cart'] ?? [];
    if (empty($cart)) {
        header("Location: index.php?action=cart");
        exit();
    }

    
    $productModel = new Product($conn);
    $rows         = $productModel->getByIds(array_keys($cart));
    $products     = [];
    foreach ($rows as $p) {
        $products[$p['id']] = $p;
    }

    $total = 0;
    foreach ($cart as $pid => $qty) {
        if (isset($products[$pid])) {
            $total += $products[$pid]['price'] * $qty;
        }
    }

    $couponModel = new Coupon($conn);
    $coupon      = $couponModel->getSessionCoupon($total);
    $coupon_id   = $coupon ? (int)$coupon['coupon_id'] : null;
    $discount_amount = $coupon ? (float)$coupon['discount_amount'] : 0;

    $addressModel = new ShippingAddress($conn);
    $zoneModel    = new DeliveryZone($conn);

    $address_id       = (int)($_POST['address_id'] ?? 0);
    $delivery_zone_id = (int)($_POST['delivery_zone_id'] ?? 0);
    $payment_method   = $_POST['payment_method'] ?? 'cod';
    $shipping         = [];

    if ($address_id) {
        $saved = $addressModel->getById($address_id, $_SESSION['user']['id']);
        if (!$saved) {
            $_SESSION['error'] = "Selected address was not found.";
            header("Location: index.php?action=checkout");
            exit();
        }

        $shipping = [
            'name'    => $saved['full_name'],
            'phone'   => $saved['phone'],
            'address' => $saved['address_line'],
            'city'    => $saved['city']
        ];

        if (!$delivery_zone_id) {
            $delivery_zone_id = (int)$saved['delivery_zone_id'];
        }
    } else {
        $shipping = [
            'name'    => trim($_POST['shipping_name'] ?? ''),
            'phone'   => trim($_POST['shipping_phone'] ?? ''),
            'address' => trim($_POST['shipping_address'] ?? ''),
            'city'    => trim($_POST['shipping_city'] ?? '')
        ];
    }

    if ($shipping['name'] === '' || $shipping['phone'] === '' || $shipping['address'] === '' || $shipping['city'] === '' || !$delivery_zone_id) {
        $_SESSION['error'] = "Please select or enter a complete shipping address and delivery zone.";
        header("Location: index.php?action=checkout");
        exit();
    }

    $zone = $zoneModel->getById($delivery_zone_id);
    if (!$zone) {
        $_SESSION['error'] = "Please select a valid delivery zone.";
        header("Location: index.php?action=checkout");
        exit();
    }

    $delivery_fee = (float)$zone['delivery_fee'];

    $orderModel = new Order($conn);
    $order_id   = $orderModel->create(
        $_SESSION['user']['id'],
        $total,
        $discount_amount,
        $delivery_fee,
        $payment_method,
        $shipping,
        $delivery_zone_id,
        $coupon_id
    );

    if ($coupon_id) {
        $coupon_id = (int)$coupon_id;
        mysqli_query($conn, "UPDATE coupons SET used_count = used_count + 1 WHERE id = $coupon_id");
    }

    foreach ($cart as $pid => $qty) {
        if (!isset($products[$pid])) continue;
        $p = $products[$pid];
        $orderModel->addItem($order_id, $pid, $p['name'], $p['price'], $qty);
        $orderModel->reduceStock($pid, $qty);
    }

    unset($_SESSION['cart'], $_SESSION['coupon'], $_SESSION['coupon_discount']);
    $_SESSION['success'] = "Order #$order_id placed successfully!";
    header("Location: index.php?action=order_confirmation&id=$order_id");
    exit();
}

function orderConfirmation($id) {
    global $conn;

    $id         = (int)$id;
    $orderModel = new Order($conn);
    $order      = $orderModel->getById($id, $_SESSION['user']['id']);

    if (!$order) {
        header("Location: index.php?action=order_history");
        exit();
    }

    $items = $orderModel->getItems($id);
    include __DIR__ . "/../views/orders/confirmation.php";
}

function orderHistory() {
    global $conn;

    $orderModel = new Order($conn);
    $orders     = $orderModel->getByUser($_SESSION['user']['id']);

    include __DIR__ . "/../views/orders/history.php";
}

function orderDetail($id) {
    global $conn;

    $id         = (int)$id;
    $orderModel = new Order($conn);
    $order      = $orderModel->getById($id, $_SESSION['user']['id']);

    if (!$order) {
        header("Location: index.php?action=order_history");
        exit();
    }

    $items = $orderModel->getItems($id);
    $returnModel  = new ReturnRequest($conn);
    $disputeModel = new Dispute($conn);
    $returns      = $returnModel->getByOrder($id, $_SESSION['user']['id']);
    $disputes     = $disputeModel->getByOrder($id, $_SESSION['user']['id']);

    include __DIR__ . "/../views/orders/detail.php";
}

function cancelOrder($id) {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=order_detail&id=" . (int)$id);
        exit();
    }

    $id         = (int)$id;
    $orderModel = new Order($conn);
    $ok         = $orderModel->cancel($id, $_SESSION['user']['id']);

    $_SESSION[$ok ? 'success' : 'error'] = $ok
        ? "Order cancelled."
        : "Cannot cancel this order (only pending orders can be cancelled).";

    header("Location: index.php?action=order_detail&id=$id");
    exit();
}

function submitReturnRequest() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=order_history");
        exit();
    }

    $order_id      = (int)($_POST['order_id'] ?? 0);
    $order_item_id = (int)($_POST['order_item_id'] ?? 0);
    $reason        = trim($_POST['reason'] ?? '');
    $details       = trim($_POST['details'] ?? '');

    if (!$order_id || $reason === '') {
        $_SESSION['error'] = "Return reason is required.";
        header("Location: index.php?action=order_detail&id=$order_id");
        exit();
    }

    $orderModel = new Order($conn);
    $order = $orderModel->getById($order_id, $_SESSION['user']['id']);
    if (!$order) {
        header("Location: index.php?action=order_history");
        exit();
    }

    $model = new ReturnRequest($conn);
    $model->add($order_id, $order_item_id, $_SESSION['user']['id'], $reason, $details);

    $_SESSION['success'] = "Return request submitted.";
    header("Location: index.php?action=order_detail&id=$order_id");
    exit();
}

function disputeList() {
    global $conn;

    $model = new Dispute($conn);
    $disputes = $model->getByUser($_SESSION['user']['id']);

    include __DIR__ . "/../views/customer/disputes.php";
}

function openDispute() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=order_history");
        exit();
    }

    $order_id    = (int)($_POST['order_id'] ?? 0);
    $subject     = trim($_POST['subject'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$order_id || $subject === '' || $description === '') {
        $_SESSION['error'] = "Dispute subject and details are required.";
        header("Location: index.php?action=order_detail&id=$order_id");
        exit();
    }

    $orderModel = new Order($conn);
    $order = $orderModel->getById($order_id, $_SESSION['user']['id']);
    if (!$order) {
        header("Location: index.php?action=order_history");
        exit();
    }

    $model = new Dispute($conn);
    $model->add($order_id, $_SESSION['user']['id'], $subject, $description);

    $_SESSION['success'] = "Dispute opened.";
    header("Location: index.php?action=disputes");
    exit();
}
