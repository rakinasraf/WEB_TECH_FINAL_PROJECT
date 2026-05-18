<?php

class DashboardModel extends Model
{
    public function getProfileImage($id)
    {
        $query = mysqli_query(
            $this->db->conn,

            "SELECT profile_image
            FROM users
            WHERE id='$id'"
        );

        $data = mysqli_fetch_assoc($query);

        return $data['profile_image'];
    }

    public function pendingOrders()
    {
        $query = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM orders
            WHERE status='Ready For Dispatch'"
        );

        return mysqli_num_rows($query);
    }

    public function activeDeliveries()
    {
        $query = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM deliveries
            WHERE delivery_status!='Delivered'
            AND delivery_status!='Failed'"
        );

        return mysqli_num_rows($query);
    }

    public function deliveredToday()
    {
        $query = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM deliveries
            WHERE delivery_status='Delivered'
            AND DATE(updated_at)=CURDATE()"
        );

        return mysqli_num_rows($query);
    }
}

?>