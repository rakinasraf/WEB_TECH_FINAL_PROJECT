<!DOCTYPE html>
<html>

<head>

<title>Ready Orders</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Ready Orders For Dispatch</h2>

<table>

<tr>

<th>Order ID</th>
<th>Customer</th>
<th>Delivery Zone</th>
<th>Order Status</th>
<th>Assign Agent</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc(
$data['orders']
)
)
{
?>

<tr>

<td>

#<?php echo $row["id"]; ?>

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
echo ucfirst($row["status"]);
?>

</td>

<td>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=assign-order&id=<?=
$row['id']
?>">

Assign Agent

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