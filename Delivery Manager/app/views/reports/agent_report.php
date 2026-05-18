<!DOCTYPE html>
<html>

<head>

<title>Agent Report</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Agent Performance Report</h2>

<table>

<tr>

<th>Agent</th>
<th>Total</th>
<th>Completed</th>
<th>Failed</th>
<th>Active</th>
<th>Failed Rate</th>
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

$failed =
$row["failed_deliveries"];

$failed_rate = 0;

if($total > 0)
{
    $failed_rate =
    ($failed / $total) * 100;
}
?>

<tr>

<td>

<?php
echo $row["name"];
?>

</td>

<td>

<?php
echo $total;
?>

</td>

<td>

<?php
echo $row["completed_deliveries"];
?>

</td>

<td>

<?php
echo $failed;
?>

</td>

<td>

<?php
echo $row["active_deliveries"];
?>

</td>

<td>

<?php
echo round(
    $failed_rate,
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