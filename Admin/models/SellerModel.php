<?php
class SellerModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllSellers() {
        $query = "SELECT s.*, u.name as owner_name, u.email as owner_email 
                  FROM sellers s 
                  JOIN users u ON s.user_id = u.id 
                  ORDER BY s.created_at DESC";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function updateApprovalStatus($seller_id, $status) {
        $query = "UPDATE sellers SET is_approved = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $seller_id);
        return mysqli_stmt_execute($stmt);
    }
}