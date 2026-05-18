<?php

class Coupon {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getValidByCode($code) {
        $code = mysqli_real_escape_string($this->conn, $code);
        $sql = "SELECT * FROM coupons
                WHERE code = '$code'
                  AND is_active = 1
                  AND valid_until >= CURDATE()
                  AND (valid_from IS NULL OR valid_from <= CURDATE())
                  AND (usage_limit IS NULL OR used_count < usage_limit)";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getValidById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM coupons
                WHERE id = $id
                  AND is_active = 1
                  AND valid_until >= CURDATE()
                  AND (valid_from IS NULL OR valid_from <= CURDATE())
                  AND (usage_limit IS NULL OR used_count < usage_limit)";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function calculateDiscount($coupon, $subtotal) {
        $discount = round($subtotal * (float)$coupon['discount_pct'] / 100, 2);

        if ($coupon['max_discount_amount'] !== null && $discount > (float)$coupon['max_discount_amount']) {
            $discount = (float)$coupon['max_discount_amount'];
        }

        return $discount;
    }

    public function clearSession() {
        unset($_SESSION['coupon'], $_SESSION['coupon_discount']);
    }

    public function saveToSession($coupon, $subtotal) {
        $discount   = $this->calculateDiscount($coupon, $subtotal);
        $finalTotal = max(0, $subtotal - $discount);

        $_SESSION['coupon'] = [
            'coupon_id'       => (int)$coupon['id'],
            'coupon_code'     => $coupon['code'],
            'discount_pct'    => (float)$coupon['discount_pct'],
            'discount_amount' => $discount,
            'subtotal'        => $subtotal,
            'final_total'     => $finalTotal
        ];
        $_SESSION['coupon_discount'] = $discount;

        return $_SESSION['coupon'];
    }

    public function getSessionCoupon($subtotal) {
        if (empty($_SESSION['coupon'])) {
            return null;
        }

        $coupon_id   = (int)($_SESSION['coupon']['coupon_id'] ?? 0);
        $oldSubtotal = (float)($_SESSION['coupon']['subtotal'] ?? 0);

        if (!$coupon_id || abs($oldSubtotal - $subtotal) >= 0.01) {
            $this->clearSession();
            return null;
        }

        $coupon = $this->getValidById($coupon_id);
        if (!$coupon || $subtotal < (float)$coupon['min_order_amount']) {
            $this->clearSession();
            return null;
        }

        return $this->saveToSession($coupon, $subtotal);
    }
}
