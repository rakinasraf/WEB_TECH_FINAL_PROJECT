<!DOCTYPE html>
<html>

<head>

<title>Manage Agents</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Delivery Agents</h2>

<a href="<?php echo BASE_URL; ?>/?url=add-agent"
class="btn">
Add Agent
</a>

<a href="<?php echo BASE_URL; ?>/?url=manage-agents"
class="btn">
All
</a>

<a href="<?php echo BASE_URL; ?>/?url=manage-agents&status=active"
class="btn">
Active
</a>

<a href="<?php echo BASE_URL; ?>/?url=manage-agents&status=inactive"
class="btn">
Inactive
</a>

<a href="<?php echo BASE_URL; ?>/?url=dashboard"
class="btn back-btn">
Back to Dashboard
</a>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Vehicle</th>
<th>Account Status</th>
<th>Current Status</th>
<th>Active Deliveries</th>
<th>Action</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc($data['agents'])
)
{
?>

<tr>

<td><?= $row["id"] ?></td>

<td><?= $row["name"] ?></td>

<td><?= $row["phone"] ?></td>

<td><?= $row["vehicle_type"] ?></td>

<td>

<?php
if($row["is_active"] == 1)
{
?>

<span class="status-active">
Active
</span>

<?php
}
else
{
?>

<span class="status-inactive">
Inactive
</span>

<?php } ?>

</td>

<td>

<?php

$status =
$row["working_status"];

if(!$status)
{
    echo "
    <span class='status-idle'>
    Idle
    </span>";
}
else
{
    echo "
    <span class='status-working'>
    ".$status."
    </span>";
}

?>

</td>

<td>

<?= $row["active_deliveries"] ?>

</td>

<td>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=edit-agent&id=<?=
$row['id']
?>">

Edit

</a>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=delete-agent&id=<?=
$row['id']
?>">

Delete

</a>

<?php
if($row["is_active"] == 1)
{
?>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=toggle-agent&id=<?=
$row['id']
?>&status=0">

Deactivate

</a>

<?php
}
else
{
?>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=toggle-agent&id=<?=
$row['id']
?>&status=1">

Activate

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>