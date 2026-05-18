<?php

class UserModel extends Model
{
    public function findUserByEmail($email)
    {
        $email = mysqli_real_escape_string(
            $this->db->conn,
            $email
        );

        $query = "
        SELECT *
        FROM users
        WHERE email='$email'
        AND role='delivery_manager'
        ";

        $result = mysqli_query(
            $this->db->conn,
            $query
        );

        if(mysqli_num_rows($result) == 1)
        {
            return mysqli_fetch_assoc($result);
        }

        return false;
    }
}

?>