<?php
class AdminDataModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    
    public function getProducts() {
        $query = "SELECT p.*, s.shop_name, c.name as category_name 
                  FROM products p
                  JOIN sellers s ON p.seller_id = s.id
                  JOIN categories c ON p.category_id = c.id
                  WHERE p.is_available = 1
                  ORDER BY p.created_at DESC";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

   
    public function softDeleteProduct($product_id) {
        $query = "UPDATE products SET is_available = 0 WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $success;
        }
        return false;
    }

    
    public function getOrders($searchId = null) {
        $query = "SELECT o.*, u.name as customer_name, u.email as customer_email 
                  FROM orders o
                  JOIN users u ON o.customer_id = u.id";
        
        if (!empty($searchId)) {
            $query .= " WHERE o.id = ? ORDER BY o.created_at DESC";
            $stmt = mysqli_prepare($this->db, $query);
            
            if ($stmt) {
                $intId = intval($searchId);
                mysqli_stmt_bind_param($stmt, "i", $intId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                mysqli_stmt_close($stmt);
                return $data;
            }
        } else {
            $query .= " ORDER BY o.created_at DESC";
            $result = mysqli_query($this->db, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }

    
    public function getCategories() {
        $query = "SELECT c1.*, c2.name as parent_name 
                  FROM categories c1 
                  LEFT JOIN categories c2 ON c1.parent_id = c2.id 
                  ORDER BY c1.id ASC";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    
    public function getCoupons() {
        $query = "SELECT cp.*, s.shop_name 
                  FROM coupons cp
                  LEFT JOIN sellers s ON cp.seller_id = s.id
                  ORDER BY cp.id DESC";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
   
    public function createCoupon($seller_id, $code, $discount_pct, $max_uses, $valid_until) {
        $query = "INSERT INTO coupons (seller_id, code, discount_pct, max_uses, valid_until, uses_count, is_active) 
                  VALUES (?, ?, ?, ?, ?, 0, 1)";
        $stmt = mysqli_prepare($this->db, $query);
        
        if ($stmt) {
            
            $seller_param = !empty($seller_id) ? intval($seller_id) : null;
            mysqli_stmt_bind_param($stmt, "isdis", $seller_param, $code, $discount_pct, $max_uses, $valid_until);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $success;
        }
        return false;
    }

    public function hardDeleteCoupon($coupon_id) {
        $query = "DELETE FROM coupons WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $coupon_id);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $success;
        }
        return false;
    }
}
?>
