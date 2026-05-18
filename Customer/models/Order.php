<?php

class Order {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($user_id, $subtotal, $discount_amount = 0, $delivery_fee = 0, $payment_method = 'cod', $shipping = [], $delivery_zone_id = null, $coupon_id = null) {
        $order_number = "ORD" . date("YmdHis") . str_pad((string)mt_rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $total_amount = max(0, $subtotal - $discount_amount + $delivery_fee);

        $shipping_name    = $shipping['name'] ?? null;
        $shipping_phone   = $shipping['phone'] ?? null;
        $shipping_address = $shipping['address'] ?? null;
        $shipping_city    = $shipping['city'] ?? null;

        $user_id          = (int)$user_id;
        $coupon_id        = $coupon_id ? (int)$coupon_id : "NULL";
        $delivery_zone_id = $delivery_zone_id ? (int)$delivery_zone_id : "NULL";
        $subtotal         = (float)$subtotal;
        $discount_amount  = (float)$discount_amount;
        $delivery_fee     = (float)$delivery_fee;
        $total_amount     = (float)$total_amount;
        $order_number     = mysqli_real_escape_string($this->conn, $order_number);
        $payment_method   = mysqli_real_escape_string($this->conn, $payment_method);
        $shipping_name    = $shipping_name === null ? "NULL" : "'" . mysqli_real_escape_string($this->conn, $shipping_name) . "'";
        $shipping_phone   = $shipping_phone === null ? "NULL" : "'" . mysqli_real_escape_string($this->conn, $shipping_phone) . "'";
        $shipping_address = $shipping_address === null ? "NULL" : "'" . mysqli_real_escape_string($this->conn, $shipping_address) . "'";
        $shipping_city    = $shipping_city === null ? "NULL" : "'" . mysqli_real_escape_string($this->conn, $shipping_city) . "'";

        $sql = "INSERT INTO orders
                    (order_number, customer_id, coupon_id, delivery_zone_id, subtotal, discount_amount, delivery_fee, total_amount,
                     status, payment_method, payment_status, shipping_name, shipping_phone, shipping_address, shipping_city)
                VALUES
                    ('$order_number', $user_id, $coupon_id, $delivery_zone_id, $subtotal, $discount_amount, $delivery_fee, $total_amount,
                     'pending', '$payment_method', 'pending', $shipping_name, $shipping_phone, $shipping_address, $shipping_city)";
        mysqli_query($this->conn, $sql);
        return mysqli_insert_id($this->conn);
    }

    public function addItem($order_id, $product_id, $product_name, $price, $quantity) {
        $line_total = $price * $quantity;

        $order_id   = (int)$order_id;
        $product_id = (int)$product_id;
        $quantity   = (int)$quantity;
        $price      = (float)$price;
        $line_total = (float)$line_total;

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, unit_price, line_total)
                VALUES ($order_id, $product_id, $quantity, $price, $line_total)";
        return mysqli_query($this->conn, $sql);
    }

    public function reduceStock($product_id, $qty) {
        $product_id = (int)$product_id;
        $qty        = (int)$qty;
        $sql = "UPDATE products SET stock_qty = stock_qty - $qty WHERE id = $product_id AND stock_qty >= $qty";
        return mysqli_query($this->conn, $sql);
    }

    public function getByUser($user_id) {
        $user_id = (int)$user_id;
        $sql = "SELECT * FROM orders WHERE customer_id = $user_id ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById($id, $user_id) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $sql = "SELECT o.*, dz.name AS delivery_zone_name
                FROM orders o
                LEFT JOIN delivery_zones dz ON dz.id = o.delivery_zone_id
                WHERE o.id = $id AND o.customer_id = $user_id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getItems($order_id) {
        $order_id = (int)$order_id;
        $sql = "SELECT oi.*,
                       p.name AS product_name,
                       oi.unit_price AS price
                FROM order_items oi
                JOIN products p ON p.id = oi.product_id
                WHERE oi.order_id = $order_id
                ORDER BY oi.id ASC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function cancel($id, $user_id) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $sql = "UPDATE orders SET status='cancelled' WHERE id=$id AND customer_id=$user_id AND status='pending'";
        mysqli_query($this->conn, $sql);
        return mysqli_affected_rows($this->conn) > 0;
    }

    public function getStatusById($id) {
        $id = (int)$id;
        $sql = "SELECT o.status, d.status AS delivery_status
                FROM orders o
                LEFT JOIN delivery_assignments d ON d.order_id = o.id
                WHERE o.id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
