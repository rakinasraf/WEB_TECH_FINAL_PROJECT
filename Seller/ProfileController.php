<?php
session_start();
require_once("database.php");
require_once("ProfileModel.php");
if(!isset($_SESSION['seller_id']))
{
    header("Location: login.php");
    exit();
}
$model = new ProfileModel($conn);

// UPDATE PROFILE
if(isset($_POST['update_profile']))
{
    $logoName = $_FILES['logo']['name'];
    $tmpName = $_FILES['logo']['tmp_name'];

    // IMAGE VALIDATION
    $ext = strtolower(
        pathinfo($logoName, PATHINFO_EXTENSION)
    );

    $allowed = ['jpg','jpeg','png'];

    if(!in_array($ext,$allowed))
    {
        $_SESSION['error'] = "Invalid Image Type";
        header("Location: profile.php");
        exit();
    }

    move_uploaded_file($tmpName,$logoName);

    $data = [

        'name' => trim($_POST['name']),
        'phone' => trim($_POST['phone']),
        'shop_name' => trim($_POST['shop_name']),
        'shop_description' => trim($_POST['description']),
        'address' => trim($_POST['address']),
        'shop_logo_path' => $tmpName,
        'user_id' => $_POST['user_id'],
        'seller_id' => $_SESSION['seller_id']
    ];

    if($model->updateProfile($data))
    {
        $_SESSION['success'] = "Updation Successful";
        header("Location: profile.php");
        exit();
    }
}
?>