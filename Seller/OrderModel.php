<?php
class OrderModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // GET ALL ORDERS
    public function getOrders($seller_id)
    {
        $sql = "SELECT
                    oi.id,
                    o.id AS order_id,
                    p.name AS product_name,
                    oi.quantity,
                    oi.unit_price,
                    oi.item_status
                FROM order_items oi
                JOIN orders o
                ON oi.order_id = o.id
                JOIN products p
                ON oi.product_id = p.id
                WHERE oi.seller_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // GET SINGLE ORDER
    public function getSingleOrder($id)
    {
        $sql = "SELECT
                    oi.*,
                    p.name AS product_name,
                    o.shipping_address,
                    o.payment_method,
                    u.name AS customer_name

                FROM order_items oi
                JOIN products p
                ON oi.product_id = p.id
                JOIN orders o
                ON oi.order_id = o.id
                JOIN users u
                ON o.customer_id = u.id
                WHERE oi.id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE STATUS
    public function updateStatus($id,$status)
    {
        $sql = "UPDATE order_items
                SET item_status=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si",$status,$id);
        return $stmt->execute();
    }
}
?>