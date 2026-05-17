<?php
session_start();
require_once("database.php");
require_once("OrderModel.php");
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}
$model = new OrderModel($conn);

// UPDATE STATUS
if(isset($_POST['update_status']))
{
    $id = $_POST['id'];
    $status = $_POST['status'];
    if($model->updateStatus($id,$status))
    {
        header("Location: orders.php");
        exit();
    }
}
?>