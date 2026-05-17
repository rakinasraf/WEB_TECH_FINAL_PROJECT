<?php
class AdminDataModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getCategories() {
        $query = "SELECT c1.*, c2.name as parent_name 
                  FROM categories c1 
                  LEFT JOIN categories c2 ON c1.parent_id = c2.id";
        return mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC);
    }

    public function getProducts() {
        $query = "SELECT p.*, s.shop_name, c.name as category_name 
                  FROM products p
                  JOIN sellers s ON p.seller_id = s.id
                  JOIN categories c ON p.category_id = c.id";
        return mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC);
    }

    public function getOrders() {
        $query = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.customer_id = u.id";
        return mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC);
    }

    public function getCoupons() {
        $query = "SELECT cp.*, s.shop_name FROM coupons cp JOIN sellers s ON cp.seller_id = s.id";
        return mysqli_fetch_all(mysqli_query($this->db, $query), MYSQLI_ASSOC);
    }
}
