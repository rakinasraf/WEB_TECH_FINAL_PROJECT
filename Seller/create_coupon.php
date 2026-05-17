<!DOCTYPE html>
<html>
<head>
<title>Create Coupon</title>
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
<h2>Create Coupon</h2>
<a href="manage_coupons.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<form action="CouponController.php"method="POST">
    Coupon Code:<br><input type="text" name="code"><br><br>
    Discount Percentage:<br><input type="number" step="0.01" name="discount_pct"><br><br>
    Max Uses:<br><input type="number" name="max_uses"><br><br>
    Valid Until:<br><input type="date" name="valid_until"><br><br>
    <button type="submit" name="create_coupon">Create Coupon</button>
</form>
</div>
</body>
</html>