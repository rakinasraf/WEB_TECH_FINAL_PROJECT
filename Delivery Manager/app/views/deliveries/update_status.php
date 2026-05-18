<!DOCTYPE html>
<html>

<head>

<title>Update Status</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Update Delivery Status</h2>

<form method="POST">

<select name="status" required>

<option value="">
Select Status
</option>

<option>
Picked Up
</option>

<option>
In Transit
</option>

<option>
Delivered
</option>

<option>
Failed
</option>

</select>

<br><br>

<input
type="submit"
name="update"
value="Update"
class="btn">

</form>

</div>

</body>
</html>