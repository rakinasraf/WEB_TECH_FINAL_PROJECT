<?php
session_start();
require_once("database.php");
require_once("SellerModel.php");

$model = new SellerModel($conn);

if(isset($_POST['action']))
{
    // REGISTER
    if($_POST['action'] == "register")
    {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);
        $shop_name = trim($_POST['shop_name']);
        $address = trim($_POST['address']);

        if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($shop_name) || empty($address))
        {
            $_SESSION['error'] = "All fields are required";
            header("Location: Register.php");
            exit();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error'] = "Invalid Email";
            header("Location: Register.php");
            exit();
        }

        if(strlen($password) < 6)
        {
            $_SESSION['error'] = "Password must be at least 6 characters";
            header("Location: Register.php");
            exit();
        }

        if(!is_numeric($phone))
        {
            $_SESSION['error'] = "Phone must be numeric";
            header("Location: Register.php");
            exit();
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'shop_name' => $shop_name,
            'address' => $address
        ];

        if($model->registerSeller($data))
        {
            $_SESSION['success'] = "Registration Successful";
            header("Location: Register.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Registration Failed";
            header("Location: Register.php");
            exit();
        }
    }

    // LOGIN
    if($_POST['action'] == "login")
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(empty($email) || empty($password))
        {
            $_SESSION['error'] = "Email and Password required";
            header("Location: Login.php");
            exit();
        }

        $seller = $model->loginSeller($email);

        if($seller)
        {
            if(password_verify($password, $seller['password_hash']))
            {
                $_SESSION['seller_id'] = $seller['seller_table_id'];
                $_SESSION['seller_name'] = $seller['name'];
                $_SESSION['role'] = $seller['role'];

                header("Location: dashboard.php");
            }
            else
            {
                $_SESSION['error'] = "Wrong Password";
                header("Location: Login.php");
                exit();
            }
        }
        else
        {
            $_SESSION['error'] = "Seller Not Found";
            header("Location: Login.php");
            exit();
        }
    }
}
?>
