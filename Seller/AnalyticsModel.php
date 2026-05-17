<?php
class AnalyticsModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // TOTAL PRODUCTS
    public function totalProducts($seller_id)
    {
        $sql = "SELECT COUNT(*) AS total_products
                FROM products
                WHERE seller_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // TOTAL ORDERS
    public function totalOrders($seller_id)
    {
        $sql = "SELECT COUNT(*) AS total_orders
                FROM order_items
                WHERE seller_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // TOTAL REVENUE
    public function totalRevenue($seller_id)
    {
        $sql = "SELECT
                SUM(quantity * unit_price) AS revenue
                FROM order_items
                WHERE seller_id=?
                AND item_status='delivered'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // LOW STOCK PRODUCTS
    public function lowStockProducts($seller_id)
    {
        $sql = "SELECT COUNT(*) AS low_stock
                FROM products
                WHERE seller_id=?
                AND stock_qty < 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // TOP SELLING PRODUCTS
    public function topSellingProducts($seller_id)
    {
        $sql = "SELECT
                    p.name,
                    SUM(oi.quantity) AS total_sold

                FROM order_items oi
                JOIN products p
                ON oi.product_id = p.id
                WHERE oi.seller_id=?
                GROUP BY oi.product_id
                ORDER BY total_sold DESC
                LIMIT 5";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>