<!DOCTYPE html>
<html>

<head>

<title>Manage Zones</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Delivery Zones</h2>

<a href="<?php echo BASE_URL; ?>/?url=add-zone"
class="btn">

Add Zone

</a>

<a href="<?php echo BASE_URL; ?>/?url=dashboard"
class="btn back-btn">

Back to Dashboard

</a>

<?php
if(isset($_SESSION["success"]))
{
    echo "
    <p class='success'>
    ".$_SESSION["success"]."
    </p>";

    unset($_SESSION["success"]);
}
?>

<table>

<tr>

<th>ID</th>
<th>Zone</th>
<th>Fee</th>
<th>Estimated Days</th>
<th>Action</th>

</tr>

<?php
while(
$row =
mysqli_fetch_assoc($data['zones'])
)
{
?>

<tr>

<td>
<?php echo $row["id"]; ?>
</td>

<td>
<?php echo $row["zone_name"]; ?>
</td>

<td>
<?php echo $row["delivery_fee"]; ?>
</td>

<td>
<?php echo $row["estimated_days"]; ?>
Days
</td>

<td>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=edit-zone&id=<?=
$row['id']
?>">

Edit

</a>

<a class="btn"

href="<?php
echo BASE_URL;
?>/?url=delete-zone&id=<?=
$row['id']
?>">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>