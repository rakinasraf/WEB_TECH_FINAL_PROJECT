<!DOCTYPE html>
<html>
<head>
<title>Analytics_Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once("database.php");
require_once("AnalyticsModel.php");
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}

$model = new AnalyticsModel($conn);

// FETCH DATA
$totalProducts = $model->totalProducts($_SESSION['seller_id']);
$totalOrders = $model->totalOrders($_SESSION['seller_id']);
$totalRevenue = $model->totalRevenue($_SESSION['seller_id']);
$lowStock = $model->lowStockProducts($_SESSION['seller_id']);
$topProducts = $model->topSellingProducts($_SESSION['seller_id']);
?>
<div class="navbar">
<h1>Seller Analytics Dashboard</h1>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<h3>Total Products:<?php echo $totalProducts['total_products']; ?></h3>
<h3>Total Orders:<?php echo $totalOrders['total_orders']; ?></h3>
<h3>Total Revenue: ৳<?php echo $totalRevenue['revenue']; ?></h3>
<h3>Low Stock Products:<?php echo $lowStock['low_stock']; ?></h3>
<hr>
<h2>Top Selling Products</h2>
<div class="container">
<table border="1" cellpadding="10">
<tr>
    <th>Product Name</th>
    <th>Total Sold</th>
</tr>
<?php while($row = $topProducts->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['total_sold']; ?></td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>