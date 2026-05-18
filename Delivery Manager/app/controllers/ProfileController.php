<?php

class ProfileController extends Controller
{
    private $profileModel;

    public function __construct()
    {
        if(!isset($_SESSION['manager']))
        {
            header(
                "Location: " .
                BASE_URL .
                "/?url=login"
            );

            exit();
        }

        $this->profileModel =
            $this->model('ProfileModel');
    }

    /* =========================
    MANAGE PROFILE
    ========================= */

    public function manageProfile()
    {
        $id =
            $_SESSION['manager_id'];

        $user =
            $this->profileModel
            ->getUser($id);

        $success = "";
        $error = "";

        /* =========================
        UPDATE PROFILE
        ========================= */

        if(isset($_POST['update_profile']))
        {
            $name =
                trim($_POST['name']);

            $email =
                trim($_POST['email']);

            $phone =
                trim($_POST['phone']);

            $image =
                $user['profile_image'];

            if(
                !empty(
                    $_FILES['profile_image']['name']
                )
            )
            {
                $filename =
                    time() . "_" .
                    $_FILES['profile_image']['name'];

                $tmp =
                    $_FILES['profile_image']['tmp_name'];

                move_uploaded_file(

                    $tmp,

                    "../public/uploads/" .
                    $filename
                );

                $image = $filename;
            }

            $this->profileModel
                ->updateProfile(

                    $id,
                    $name,
                    $email,
                    $phone,
                    $image
                );

            $_SESSION['manager'] =
                $name;

            $success =
                "Profile Updated Successfully";

            $user =
                $this->profileModel
                ->getUser($id);
        }

        /* =========================
        CHANGE PASSWORD
        ========================= */

        if(isset($_POST['change_password']))
        {
            $old =
                $_POST['old_password'];

            $new =
                $_POST['new_password'];

            $confirm =
                $_POST['confirm_password'];

            if(
                $user['password_hash']
                !=
                $old
            )
            {
                $error =
                "Old Password Incorrect";
            }

            elseif($new != $confirm)
            {
                $error =
                "Passwords Do Not Match";
            }

            else
            {
                $this->profileModel
                ->changePassword(
                    $id,
                    $new
                );

                $success =
                "Password Changed Successfully";
            }
        }

        $data = [

            'user' => $user,

            'success' => $success,

            'error' => $error
        ];

        $this->view(
            'profile/manage_profile',
            $data
        );
    }
}

?>