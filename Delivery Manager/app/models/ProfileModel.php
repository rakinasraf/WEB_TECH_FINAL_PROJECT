<?php

class ProfileModel extends Model
{
    /* =========================
    GET USER
    ========================= */

    public function getUser($id)
    {
        $query = mysqli_query(

            $this->db->conn,

            "SELECT *

            FROM users

            WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    /* =========================
    UPDATE PROFILE
    ========================= */

    public function updateProfile(
        $id,
        $name,
        $email,
        $phone,
        $image = null
    )
    {
        if($image != null)
        {
            mysqli_query(

                $this->db->conn,

                "UPDATE users

                SET

                name='$name',

                email='$email',

                phone='$phone',

                profile_image='$image'

                WHERE id='$id'"
            );
        }
        else
        {
            mysqli_query(

                $this->db->conn,

                "UPDATE users

                SET

                name='$name',

                email='$email',

                phone='$phone'

                WHERE id='$id'"
            );
        }
    }

    /* =========================
    CHANGE PASSWORD
    ========================= */

    public function changePassword(
        $id,
        $new_password
    )
    {
        mysqli_query(

            $this->db->conn,

            "UPDATE users

            SET password_hash='$new_password'

            WHERE id='$id'"
        );
    }
}

?>