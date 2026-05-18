<?php

class Review {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($user_id, $product_id, $rating, $comment) {
        $user_id    = (int)$user_id;
        $product_id = (int)$product_id;
        $rating     = (int)$rating;
        $comment    = mysqli_real_escape_string($this->conn, $comment);

        $sql = "INSERT INTO reviews (customer_id, product_id, rating, review_text)
                VALUES ($user_id, $product_id, $rating, '$comment')";
        return mysqli_query($this->conn, $sql);
    }

    public function getByProduct($product_id) {
        $product_id = (int)$product_id;
        $sql = "SELECT r.*,
                       r.customer_id AS user_id,
                       r.review_text AS comment,
                       u.name AS user_name
                FROM reviews r
                JOIN users u ON u.id = r.customer_id
                WHERE r.product_id = $product_id
                ORDER BY r.created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function alreadyReviewed($user_id, $product_id) {
        $user_id    = (int)$user_id;
        $product_id = (int)$product_id;
        $sql = "SELECT id FROM reviews WHERE customer_id=$user_id AND product_id=$product_id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function delete($id, $user_id) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $sql = "DELETE FROM reviews WHERE id=$id AND customer_id=$user_id";
        return mysqli_query($this->conn, $sql);
    }

    public function update($id, $user_id, $rating, $comment) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $rating  = (int)$rating;
        $comment = mysqli_real_escape_string($this->conn, $comment);

        $sql = "UPDATE reviews
                SET rating=$rating, review_text='$comment'
                WHERE id=$id AND customer_id=$user_id";
        return mysqli_query($this->conn, $sql);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT r.*, r.customer_id AS user_id, r.review_text AS comment
                FROM reviews r
                WHERE r.id=$id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
