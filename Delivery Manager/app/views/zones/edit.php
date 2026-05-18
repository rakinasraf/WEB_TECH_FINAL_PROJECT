<!DOCTYPE html>
<html>

<head>

<title>Edit Zone</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Edit Zone</h2>

<form method="POST">

<input
type="text"
name="zone"

value="<?php
echo $data['zone']['zone_name'];
?>">

<input
type="number"
name="fee"

value="<?php
echo $data['zone']['delivery_fee'];
?>">

<input
type="number"
name="days"

value="<?php
echo $data['zone']['estimated_days'];
?>">

<div>

<input
type="submit"
name="edit"
value="Edit Zone"
class="btn">

<a href="<?php echo BASE_URL; ?>/?url=manage-zones"
class="btn back-btn">

Back to Delivery Zone

</a>

</div>

</form>

</div>

</body>
</html>