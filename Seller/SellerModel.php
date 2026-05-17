<?php
require_once("database.php");
class SellerModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // REGISTER
    public function registerSeller($data)
    {
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(name,email,password_hash,phone,role)
                VALUES(?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $role = "seller";
        $stmt->bind_param(
            "sssss",
            $data['name'],
            $data['email'],
            $passwordHash,
            $data['phone'],
            $role
        );

        if($stmt->execute())
        {
            $user_id = $stmt->insert_id;
            $sql2 = "INSERT INTO sellers(user_id,shop_name,address)
                     VALUES(?,?,?)";

            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bind_param(
                "iss",
                $user_id,
                $data['shop_name'],
                $data['address']
            );
            return $stmt2->execute();
        }
        return false;
    }

    // LOGIN
    public function loginSeller($email)
    {
        $sql = "SELECT
            users.*,
            sellers.id AS seller_table_id
        FROM users
        JOIN sellers
        ON users.id = sellers.user_id
        WHERE users.email=?
        AND users.role='seller'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>