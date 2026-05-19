<?php
class DashboardModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

   public function getUserStats() {
       
        $query = "SELECT 
                    SUM(CASE WHEN role = 'customer' AND is_active = 1 THEN 1 ELSE 0 END) as customer,
                    SUM(CASE WHEN role = 'seller' AND is_active = 1 THEN 1 ELSE 0 END) as seller,
                    SUM(CASE WHEN role = 'delivery_manager' AND is_active = 1 THEN 1 ELSE 0 END) as delivery_manager
                  FROM users";
                  
        $result = mysqli_query($this->db, $query);
        
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            
           
            return [
                'customer'         => (int)($data['customer'] ?? 0),
                'seller'           => (int)($data['seller'] ?? 0),
                'delivery_manager' => (int)($data['delivery_manager'] ?? 0)
            ];
        }
        
    
        return ['customer' => 0, 'seller' => 0, 'delivery_manager' => 0];
    }

    public function getRevenueStats() {
       
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