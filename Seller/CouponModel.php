<?php
class CouponModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // CREATE COUPON
    public function createCoupon($data)
    {
        $sql = "INSERT INTO coupons
                (seller_id,code,discount_pct,
                 max_uses,valid_until)
                VALUES(?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isdis",
            $data['seller_id'],
            $data['code'],
            $data['discount_pct'],
            $data['max_uses'],
            $data['valid_until']
        );
        return $stmt->execute();
    }

    // GET ALL COUPONS
    public function getCoupons($seller_id)
    {
        $sql = "SELECT * FROM coupons
                WHERE seller_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // TOGGLE STATUS
    public function toggleCoupon($id,$status)
    {
        $sql = "UPDATE coupons
                SET is_active=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii",$status,$id);
        return $stmt->execute();
    }

    // DELETE COUPON
    public function deleteCoupon($id)
    {
        $sql = "DELETE FROM coupons
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }
}
?>