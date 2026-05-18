<?php
class DashboardModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getUserStats() {
        $query = "SELECT role, COUNT(*) as total FROM users GROUP BY role";
        $result = mysqli_query($this->db, $query);
        $stats = ['customer' => 0, 'seller' => 0, 'delivery_manager' => 0, 'admin' => 0];
        while ($row = mysqli_fetch_assoc($result)) {
            if (array_key_exists($row['role'], $stats)) {
                $stats[$row['role']] = $row['total'];
            }
        }
        return $stats;
    }

    public function getRevenueStats() {
        // Automatically tallies revenue from orders and tracks admin commissions
        $query = "SELECT 
                    SUM(total_amount) as gv, 
                    SUM(discount_amount) as discounts,
                    (SELECT SUM(oi.unit_price * oi.quantity * (s.commission_rate / 100)) 
                     FROM order_items oi 
                     JOIN sellers s ON oi.seller_id = s.id 
                     JOIN orders o ON oi.order_id = o.id 
                     WHERE o.status = 'delivered') as platform_commission
                  FROM orders";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($result);
    }
}