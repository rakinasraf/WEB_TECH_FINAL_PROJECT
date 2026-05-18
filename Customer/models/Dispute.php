<?php

class Dispute {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($order_id, $customer_id, $subject, $description) {
        $order_id    = (int)$order_id;
        $customer_id = (int)$customer_id;
        $subject     = mysqli_real_escape_string($this->conn, $subject);
        $description = mysqli_real_escape_string($this->conn, $description);

        $sql = "INSERT INTO disputes (order_id, customer_id, opened_by_id, subject, description, status)
                VALUES ($order_id, $customer_id, $customer_id, '$subject', '$description', 'open')";
        return mysqli_query($this->conn, $sql);
    }

    public function getByUser($customer_id) {
        $customer_id = (int)$customer_id;
        $sql = "SELECT d.*, o.order_number
                FROM disputes d
                JOIN orders o ON o.id = d.order_id
                WHERE d.customer_id = $customer_id
                ORDER BY d.created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getByOrder($order_id, $customer_id) {
        $order_id    = (int)$order_id;
        $customer_id = (int)$customer_id;
        $sql = "SELECT * FROM disputes
                WHERE order_id=$order_id AND customer_id=$customer_id
                ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
