<!DOCTYPE html>
<html>

<head>

<title>Zone Report</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Zone Performance Report</h2>

<table>

<tr>

<th>Zone</th>
<th>Fee</th>
<th>Estimated Days</th>
<th>Total Deliveries</th>
<th>Successful</th>
<th>Failed</th>
<th>Success Rate</th>
<th>Avg Delivery Time</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc(
$data['report']
)
)
{

$total =
$row["total_deliveries"];

$success =
$row["successful_deliveries"];

$success_rate = 0;

if($total > 0)
{
    $success_rate =
    ($success / $total) * 100;
}
?>

<tr>

<td>

<?php
echo $row["zone_name"];
?>

</td>

<td>

৳<?php
echo $row["delivery_fee"];
?>

</td>

<td>

<?php
echo $row["estimated_days"];
?>

Days

</td>

<td>

<?php
echo $total;
?>

</td>

<td>

<?php
echo $success;
?>

</td>

<td>

<?php
echo $row["failed_deliveries"];
?>

</td>

<td>

<?php
echo round(
    $success_rate,
    2
);
?>%

</td>

<td>

<?php
echo round(
    $row["avg_delivery_time"],
    2
);
?>

Hours

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