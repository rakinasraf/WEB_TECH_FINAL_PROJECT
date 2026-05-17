<!DOCTYPE html>
<html>
<head>
<title>Manage Coupon</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once("database.php");
require_once("CouponModel.php");
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}
$model = new CouponModel($conn);
$coupons = $model->getCoupons($_SESSION['seller_id']);
?>
<div class="navbar">
<h2>Manage Coupons</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<a href="create_coupon.php" class="btn btn-add">Create New Coupon</a>
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Code</th>
    <th>Discount</th>
    <th>Max Uses</th>
    <th>Used</th>
    <th>Valid Until</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php while($row = $coupons->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['discount_pct']; ?>%</td>
    <td><?php echo $row['max_uses']; ?></td>
    <td><?php echo $row['uses_count']; ?></td>
    <td><?php echo $row['valid_until']; ?></td>
    <td>
        <?php
        if($row['is_active'] == 1){echo "Active";}
        else{echo "Inactive";}
        ?>
    </td>
    <td>
        <?php
        if($row['is_active'] == 1)
        {
        ?>
        <a href="CouponController.php?toggle=<?php echo $row['id']; ?>&status=0">Deactivate</a>
        <?php
        }
        else
        {
        ?>
        <a href="CouponController.php?toggle=<?php echo $row['id']; ?>&status=1">Activate</a>
        <?php } ?>
        <a href="CouponController.php?delete=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>