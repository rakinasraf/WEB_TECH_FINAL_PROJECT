<?php

class ShippingAddress {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getByUser($user_id) {
        $user_id = (int)$user_id;
        $sql = "SELECT a.*, z.name AS zone_name, z.delivery_fee
                FROM shipping_addresses a
                LEFT JOIN delivery_zones z ON z.id = a.delivery_zone_id
                WHERE a.user_id = $user_id
                ORDER BY a.is_default DESC, a.id DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById($id, $user_id) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $sql = "SELECT a.*, z.name AS zone_name, z.delivery_fee
                FROM shipping_addresses a
                LEFT JOIN delivery_zones z ON z.id = a.delivery_zone_id
                WHERE a.id = $id AND a.user_id = $user_id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function add($user_id, $full_name, $phone, $address_line, $city, $delivery_zone_id, $is_default) {
        if ($is_default) {
            $this->clearDefault($user_id);
        }

        $user_id          = (int)$user_id;
        $full_name        = mysqli_real_escape_string($this->conn, $full_name);
        $phone            = mysqli_real_escape_string($this->conn, $phone);
        $address_line     = mysqli_real_escape_string($this->conn, $address_line);
        $city             = mysqli_real_escape_string($this->conn, $city);
        $delivery_zone_id = (int)$delivery_zone_id;
        $is_default       = (int)$is_default;

        $sql = "INSERT INTO shipping_addresses
                    (user_id, full_name, phone, address_line, city, delivery_zone_id, is_default)
                VALUES
                    ($user_id, '$full_name', '$phone', '$address_line', '$city', $delivery_zone_id, $is_default)";
        return mysqli_query($this->conn, $sql);
    }

    public function update($id, $user_id, $full_name, $phone, $address_line, $city, $delivery_zone_id, $is_default) {
        if ($is_default) {
            $this->clearDefault($user_id);
        }

        $id               = (int)$id;
        $user_id          = (int)$user_id;
        $full_name        = mysqli_real_escape_string($this->conn, $full_name);
        $phone            = mysqli_real_escape_string($this->conn, $phone);
        $address_line     = mysqli_real_escape_string($this->conn, $address_line);
        $city             = mysqli_real_escape_string($this->conn, $city);
        $delivery_zone_id = (int)$delivery_zone_id;
        $is_default       = (int)$is_default;

        $sql = "UPDATE shipping_addresses
                SET full_name='$full_name',
                    phone='$phone',
                    address_line='$address_line',
                    city='$city',
                    delivery_zone_id=$delivery_zone_id,
                    is_default=$is_default
                WHERE id=$id AND user_id=$user_id";
        return mysqli_query($this->conn, $sql);
    }

    public function delete($id, $user_id) {
        $id      = (int)$id;
        $user_id = (int)$user_id;
        $sql = "DELETE FROM shipping_addresses WHERE id=$id AND user_id=$user_id";
        return mysqli_query($this->conn, $sql);
    }

    public function clearDefault($user_id) {
        $user_id = (int)$user_id;
        $sql = "UPDATE shipping_addresses SET is_default=0 WHERE user_id=$user_id";
        return mysqli_query($this->conn, $sql);
    }
}
