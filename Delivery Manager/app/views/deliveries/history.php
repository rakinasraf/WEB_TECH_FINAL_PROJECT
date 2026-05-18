<!DOCTYPE html>
<html>

<head>

<title>Delivery History</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Delivery History</h2>

<table>

<tr>

<th>Delivery ID</th>
<th>Order ID</th>
<th>Customer</th>
<th>Zone</th>
<th>Delivery Agent</th>
<th>Status</th>
<th>Reassign</th>
<th>Created At</th>
<th>Last Updated</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc(
$data['history']
)
)
{
?>

<tr>

<td>

<?php
echo $row["id"];
?>

</td>

<td>

#<?php
echo $row["order_id"];
?>

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

<b>

<?php
echo $row["delivery_status"];
?>

</b>

</td>

<td>

<?php
if(
$row["delivery_status"]
==
"Failed"
)
{
?>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=reassign-delivery&id=<?=
$row['id']
?>">

Reassign

</a>

<?php
}
else
{
    echo "-";
}
?>

</td>

<td>

<?php
echo $row["created_at"];
?>

</td>

<td>

<?php
echo $row["updated_at"];
?>

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