<!DOCTYPE html>
<html>

<head>

<title>Add Zone</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Add Delivery Zone</h2>

<form method="POST">

<input
type="text"
name="zone"
placeholder="Zone Name"
required>

<input
type="number"
name="fee"
placeholder="Delivery Fee"
required>

<input
type="number"
name="days"
placeholder="Estimated Delivery Days"
required>

<div class="button-group">

<input
type="submit"
name="add"
value="Add Zone"
class="btn">

<a href="<?php echo BASE_URL; ?>/?url=manage-zones"
class="btn back-btn"
style="margin-left:20px">

Back to Delivery Zone

</a>

</div>

</form>

<p class="success">
<?php echo $data['success']; ?>
</p>

</div>

</body>
</html>