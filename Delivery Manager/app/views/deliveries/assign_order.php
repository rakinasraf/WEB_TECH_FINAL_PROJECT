<!DOCTYPE html>
<html>

<head>

<title>Assign Order</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Assign Delivery Agent</h2>

<form method="POST">

<select name="agent_id" required>

<option value="">
Select Delivery Agent
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

<?php echo $row['name']; ?>

(
<?php echo $row['vehicle_type']; ?>
)

</option>

<?php } ?>

</select>

<br><br>

<input
type="submit"
name="assign"
value="Assign Order"
class="btn">

</form>

<br>

<a href="<?php echo BASE_URL; ?>/?url=ready-orders"
class="btn back-btn">

Back

</a>

</div>

</body>
</html>