<!DOCTYPE html>
<html>

<head>

<title>Active Deliveries</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Active Deliveries</h2>

<table>

<tr>

<th>Order ID</th>
<th>Customer</th>
<th>Zone</th>
<th>Assigned Agent</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Status</th>
<th>Assigned Since</th>
<th>Update</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc(
$data['deliveries']
)
)
{
?>

<tr>

<td>

#<?php echo $row["order_id"]; ?>

</td>

<td>

<?php
echo $row["customer_name"];
?>

</td>

<td>

<?php
echo $row["zone_name"];
?>

</td>

<td>

<?php
echo $row["agent_name"];
?>

</td>

<td>

<?php
echo $row["vehicle_type"];
?>

</td>

<td>

<?php
echo $row["phone"];
?>

</td>

<td>

<b>

<?php
echo $row["delivery_status"];
?>

</b>

</td>

<td>

<?php
echo $row["assigned_hours"];
?>

hours ago

</td>

<td>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=update-delivery-status&id=<?=
$row['id']
?>">

Update

</a>

</td>

</tr>

<?php } ?>

</table>

<br>

<a href="<?php echo BASE_URL; ?>/?url=dashboard"
class="btn back-btn">

Back to Dashboard

</a>

</div>

</body>
</html>