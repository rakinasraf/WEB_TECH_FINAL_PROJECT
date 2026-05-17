<?php
class ProfileModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // GET PROFILE
    public function getProfile($seller_id)
    {
        $sql = "SELECT
                    sellers.*,
                    users.name,
                    users.email,
                    users.phone

                FROM sellers
                JOIN users
                ON sellers.user_id = users.id
                WHERE sellers.id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$seller_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE PROFILE
    public function updateProfile($data)
    {
        // UPDATE USER TABLE
        $sql1 = "UPDATE users
                 SET name=?,
                     phone=?
                 WHERE id=?";

        $stmt1 = $this->conn->prepare($sql1);

        $stmt1->bind_param(
            "ssi",
            $data['name'],
            $data['phone'],
            $data['user_id']
        );

        $stmt1->execute();

        // UPDATE SELLER TABLE
        $sql2 = "UPDATE sellers
                 SET shop_name=?,
                     shop_description=?,
                     address=?,
                     shop_logo_path=?

                 WHERE id=?";

        $stmt2 = $this->conn->prepare($sql2);

        $stmt2->bind_param(
            "ssssi",
            $data['shop_name'],
            $data['shop_description'],
            $data['address'],
            $data['shop_logo_path'],
            $data['seller_id']
        );
        return $stmt2->execute();
    }
}
?>