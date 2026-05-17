<?php
session_start();
require_once("database.php");
require_once("CouponModel.php");

$model = new CouponModel($conn);

// CREATE COUPON
if(isset($_POST['create_coupon']))
{
    $data = [
        'seller_id' => $_SESSION['seller_id'],
        'code' => $_POST['code'],
        'discount_pct' => $_POST['discount_pct'],
        'max_uses' => $_POST['max_uses'],
        'valid_until' => $_POST['valid_until']
    ];

    if($model->createCoupon($data))
    {
        header("Location: manage_coupons.php");
        exit();
    }
}

// TOGGLE COUPON
if(isset($_GET['toggle']))
{
    $id = $_GET['toggle'];
    $status = $_GET['status'];
    if($model->toggleCoupon($id,$status))
    {
        header("Location: manage_coupons.php");
        exit();
    }
}

// DELETE COUPON
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];
    if($model->deleteCoupon($id))
    {
        header("Location: manage_coupons.php");
        exit();
    }
}
?>