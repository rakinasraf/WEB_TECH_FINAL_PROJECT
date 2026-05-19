<?php
class SellerModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

   
    public function getAllSellers() {
        $query = "SELECT s.*, u.name as owner_name, u.email as owner_email, u.phone as owner_phone, u.is_active
                  FROM sellers s 
                  JOIN users u ON s.user_id = u.id 
                  WHERE u.is_active = 1
                  ORDER BY s.created_at DESC";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

   
    public function createSeller($name, $email, $password, $phone, $shop_name, $address, $commission_rate) {
       
        mysqli_begin_transaction($this->db);

        try {
          
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $role = 'seller';

            $userQuery = "INSERT INTO users (name, email, password_hash, phone, role, is_active) VALUES (?, ?, ?, ?, ?, 1)";
            $userStmt = mysqli_prepare($this->db, $userQuery);
            mysqli_stmt_bind_param($userStmt, "sssss", $name, $email, $password_hash, $phone, $role);
            mysqli_stmt_execute($userStmt);
            
            $user_id = mysqli_insert_id($this->db);

            $sellerQuery = "INSERT INTO sellers (user_id, shop_name, address, commission_rate, is_approved) VALUES (?, ?, ?, ?, 1)";
            $sellerStmt = mysqli_prepare($this->db, $sellerQuery);
            mysqli_stmt_bind_param($sellerStmt, "issd", $user_id, $shop_name, $address, $commission_rate);
            mysqli_stmt_execute($sellerStmt);

            mysqli_commit($this->db);
            return true;

        } catch (Exception $e) {
            mysqli_rollback($this->db);
            error_log("Failed to initialize merchant creation profile sequence: " . $e->getMessage());
            return false;
        }
    }

   
    public function deleteSeller($seller_id) {
        $findQuery = "SELECT user_id FROM sellers WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($this->db, $findQuery);
        mysqli_stmt_bind_param($stmt, "i", $seller_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $seller = mysqli_fetch_assoc($result);

        if ($seller) {
            $user_id = $seller['user_id'];
            
          
            $updateQuery = "UPDATE users SET is_active = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($this->db, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "i", $user_id);
            return mysqli_stmt_execute($updateStmt);
        }
        return false;
    }

    public function updateApprovalStatus($seller_id, $status) {
        $query = "UPDATE sellers SET is_approved = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $seller_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>