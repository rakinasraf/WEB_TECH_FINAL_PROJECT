<?php

class ReturnRequest {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($order_id, $order_item_id, $customer_id, $reason, $details) {
        if ($order_item_id <= 0) {
            $order_item_id = null;
        }

        $order_id      = (int)$order_id;
        $order_item_id = $order_item_id === null ? "NULL" : (int)$order_item_id;
        $customer_id   = (int)$customer_id;
        $reason        = mysqli_real_escape_string($this->conn, $reason);
        $details       = mysqli_real_escape_string($this->conn, $details);

        $sql = "INSERT INTO return_requests (order_id, order_item_id, customer_id, reason, details)
                VALUES ($order_id, $order_item_id, $customer_id, '$reason', '$details')";
        return mysqli_query($this->conn, $sql);
    }

    public function getByOrder($order_id, $customer_id) {
        $order_id    = (int)$order_id;
        $customer_id = (int)$customer_id;
        $sql = "SELECT rr.*, p.name AS product_name
                FROM return_requests rr
                LEFT JOIN order_items oi ON oi.id = rr.order_item_id
                LEFT JOIN products p ON p.id = oi.product_id
                WHERE rr.order_id=$order_id AND rr.customer_id=$customer_id
                ORDER BY rr.created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
