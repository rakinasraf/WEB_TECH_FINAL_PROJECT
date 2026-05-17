<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}
?>
<div class="navbar">
<h1>Seller Dashboard</h1>
<a href="Logout.php" class="btn btn-delete">Logout</a>
</div>
<div class="container">
Welcome,<?php echo $_SESSION['seller_name']; ?><br><br>
<a href="Profile.php"  class="btn btn-edit">My Profile</a><br><br>
<a href="add_product.php" class="btn btn-edit">Add Product</a><br><br>
<a href="manage_products.php" class="btn btn-edit">Manage Products</a><br><br>
<a href="orders.php" class="btn btn-edit">Manage Orders</a><br><br>
<a href="manage_coupons.php" class="btn btn-edit">Manage Coupons</a><br><br>
<a href="analytics_dashboard.php"  class="btn btn-edit">View Analytics</a>
</div>
</body>
</html>