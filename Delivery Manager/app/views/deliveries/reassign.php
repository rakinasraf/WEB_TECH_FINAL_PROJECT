<!DOCTYPE html>
<html>

<head>

<title>Reassign Delivery</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Reassign Failed Delivery</h2>

<form method="POST">

<select name="agent_id" required>

<option value="">
Select New Agent
</option>

<?php
while(
$row =
mysqli_fetch_assoc(
$data['agents']
)
)
{
?>

<option value="<?php echo $row['id']; ?>">

<?php
echo $row['name'];
?>

-

<?php
echo $row['vehicle_type'];
?>

</option>

<?php } ?>

</select>

<br><br>

<input
type="submit"
name="reassign"
value="Reassign Delivery"
class="btn">

</form>

</div>

</body>
</html>