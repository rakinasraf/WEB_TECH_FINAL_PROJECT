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
    header("Location: Login.php");
    exit();
}
$model = new OrderModel($conn);
$orders = $model->getOrders($_SESSION['seller_id']);
?>
<div class="navbar">
<h2>Seller Orders</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<table border="1" cellpadding="10">
<tr>
    <th>Order ID</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php while($row = $orders->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['order_id']; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['unit_price']; ?></td>
    <td><?php echo $row['item_status']; ?></td>
    <td><a href="order_details.php?id=<?php echo $row['id']; ?>">View</a>
    </td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>