<?php

class Wishlist {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($user_id, $product_id) {
        if ($this->exists($user_id, $product_id)) return true;

        $user_id    = (int)$user_id;
        $product_id = (int)$product_id;
        $sql = "INSERT INTO wishlists (user_id, product_id) VALUES ($user_id, $product_id)";
        return mysqli_query($this->conn, $sql);
    }

    public function remove($user_id, $product_id) {
        $user_id    = (int)$user_id;
        $product_id = (int)$product_id;
        $sql = "DELETE FROM wishlists WHERE user_id=$user_id AND product_id=$product_id";
        return mysqli_query($this->conn, $sql);
    }

    public function exists($user_id, $product_id) {
        $user_id    = (int)$user_id;
        $product_id = (int)$product_id;
        $sql = "SELECT id FROM wishlists WHERE user_id=$user_id AND product_id=$product_id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function getByUser($user_id) {
        $user_id = (int)$user_id;
        $sql = "SELECT w.*,
                       p.name,
                       p.price,
                       p.primary_image_path AS image,
                       p.stock_qty AS stock
                FROM wishlists w
                JOIN products p ON p.id = w.product_id
                WHERE w.user_id = $user_id
                ORDER BY w.id DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
