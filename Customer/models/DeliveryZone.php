<?php

class DeliveryZone {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM delivery_zones
                WHERE is_active = 1
                ORDER BY city, name";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM delivery_zones WHERE id=$id AND is_active=1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
