<!DOCTYPE html>
<html>
<head>
<title>Order Details</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once("database.php");
require_once("OrderModel.php");
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: login.php");
    exit();
}
$model = new OrderModel($conn);
$order = $model->getSingleOrder($_GET['id']);
?>
<div class="navbar">
<h2>Order Details</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<p>Customer:<?php echo $order['customer_name']; ?></p>
<p>Product:<?php echo $order['product_name']; ?></p>
<p>Quantity:<?php echo $order['quantity']; ?></p>
<p>Shipping Address:<?php echo $order['shipping_address']; ?></p>
<p>Payment Method:<?php echo $order['payment_method']; ?></p>
<p>Current Status:<?php echo $order['item_status']; ?></p>
<hr>
<h3>Update Status</h3>
<form action="OrderController.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
    <select name="status">
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="shipped">Shipped</option>
        <option value="delivered">Delivered</option>
    </select>
    <br><br>
    <button type="submit" name="update_status">Update Status</button>
</form>
</div>
</body>
</html>